<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectDescriptionRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Applicant;
use App\Models\Division;
use App\Models\Schedule;
use DateTime;
use DateTimeZone;
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
        $data['divisions'] = Division::all();
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
            ['id', 'priority_division1', 'priority_division2', 'documents'],
            ['priorityDivision1', 'priorityDivision2']
        )->toArray();

        if ($selected == 2 && !$applicant['priority_division2']) abort(404);

        $data['applicant'] = $applicant;
        $data['selected'] = $selected;

        if (!$selected) return view('main.projects_form', $data);

        $timezone = new DateTimeZone('Asia/Jakarta');
        $now = new DateTime('now', $timezone);
        $nowTimestamp = $now->getTimestamp() + $now->getOffset();
        $data['passedDeadline'] = $nowTimestamp > self::getProjectDeadline($applicant, $nrp, $selected);
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

        $selectedInterview = array_filter($interviews, function ($interview) use ($selectedPriority) {
            return $interview['type'] == $selectedPriority || $interview['type'] == 0;
        });

        if (count($selectedInterview) > 1) {
            Log::warning('Expected 1 interview, but more than 1 interview found for applicant {nrp} when selecting priority {}', [
                'nrp' => $nrp,
                'priority' => $selectedPriority,
            ]);
        }
        $interviewTime = ((int) $selectedInterview[0]['time']) * 3600;
        $interviewDate = strtotime($selectedInterview[0]['date']['date']);

        return $interviewTime + $interviewDate;
    }

    public static function getProjectDeadline($applicant, $nrp, $selectedPriority)
    {
        $interviewStartTimestamp = self::getInterviewStartTimestamp($applicant, $nrp, $selectedPriority);
        $interval = $applicant['priority_division' . $selectedPriority]['project_deadline'];
        $projectDeadline = $interviewStartTimestamp + $interval;

        return $projectDeadline;
    }
}