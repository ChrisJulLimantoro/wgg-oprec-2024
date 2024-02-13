<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectDescriptionRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Applicant;
use App\Models\Division;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class ProjectController extends BaseController
{
    public function __construct(Applicant $model)
    {
        parent::__construct($model);
    }

    public function index(?Division $division = null)
    {
        $data['title'] = 'Projects';

        $userDivision = Division::where('id', session('division_id'))
            ->first();
        $divisionsSlugWithFullAccess = ['bph', 'it'];

        if (in_array($userDivision->slug, $divisionsSlugWithFullAccess)) {
            $data['divisions'] = Division::all();
        } else {
            $data['divisions'] = [$userDivision];
        }
        $data['division'] = $division;

        return view('admin.project', $data);
    }

    public function storeProjectDescription(StoreProjectDescriptionRequest $request, Division $division)
    {
        $division->project = $request->project;
        $division->project_deadline = $request->project_deadline;
        $division->save();

        return back()->with('success', 'Deskripsi proyek berhasil disimpan.');
    }

    public function projectsForm(?int $selected = null)
    {
        $nrp = strtolower(session('nrp'));
        $data['title'] = 'Projects Form';
        $applicant = $this->model->findByNrp(
            $nrp,
            ['id', 'priority_division1', 'priority_division2', 'documents', 'stage', 'astor'],
            ['priorityDivision1', 'priorityDivision2']
        );

        if (!$applicant || $applicant->stage < 4)
            return redirect()->route('applicant.schedule-form')
                ->with('previous_stage_not_completed', 'Silahkan lakukan interview terlebih dahulu!');

        if ($selected == 2 && !$applicant['priority_division2']) abort(404);

        $applicant = $applicant->toArray();
        $data['applicant'] = $applicant;
        $data['selected'] = $selected;
        if ($applicant['astor'])
            return view('main.projects_form', $data);
    

        if (!$selected) return view('main.projects_form', $data);

        $nowTimestamp = now()->getTimestamp();
        $data['deadline'] = self::getProjectDeadline($applicant, $nrp, $selected);
        $data['passedDeadline'] = $nowTimestamp > $data['deadline'];
        $data['projectDescription'] = ($nowTimestamp > self::getInterviewStartTimestamp($applicant, $nrp, $selected))
            ? ($applicant['priority_division' . $selected]['project'] ?? 'Tidak ada proyek untuk divisi ini')
            : 'Silahkan lakukan interview terlebih dahulu untuk melihat deskripsi proyek';

        return view('main.projects_form', $data);
    }

    public function storeProject(StoreProjectRequest $request, $selectedPriority)
    {
        $nrp = strtolower(session('nrp'));
        $applicant = $this->model->findByNrp($nrp, relations: ['priorityDivision' . $selectedPriority]);
        $applicant->addProject($request->project, $selectedPriority);

        return back()->with('success', 'Proyek divisi ' . $applicant->{'priorityDivision' . $selectedPriority}->name . ' berhasil disimpan.');
    }

    private static function getInterviewStartTimestamp($applicant, $nrp, $selectedPriority)
    {
        $interviews = Schedule::with('date')->where('applicant_id', $applicant['id'])
            ->get()->toArray();

        $selectedInterviews = array_filter($interviews, function ($interview) use ($selectedPriority) {
            return $interview['type'] == $selectedPriority || $interview['type'] == 0;
        });

        if (count($selectedInterviews) > 1) {
            Log::warning('Expected 1 interview, but more than 1 interview found for applicant {nrp} when selecting priority {}', [
                'nrp' => $nrp,
                'priority' => $selectedPriority,
            ]);
        }
        $selectedInterview = reset($selectedInterviews);
        $interviewTime = ((int) $selectedInterview['time']) * 3600;
        $interviewDate = strtotime($selectedInterview['date']['date']);

        return $interviewTime + $interviewDate;
    }

    public static function getProjectDeadline($applicant, $nrp, $selectedPriority)
    {
        $interviewStartTimestamp = self::getInterviewStartTimestamp($applicant, $nrp, $selectedPriority);
        $interval = $applicant['priority_division' . $selectedPriority]['project_deadline'];
        $projectDeadline = $interviewStartTimestamp + $interval;
        $hour = 3600;

        return $projectDeadline + $hour;
    }
}
