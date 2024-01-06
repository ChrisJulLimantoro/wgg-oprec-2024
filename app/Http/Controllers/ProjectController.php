<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Applicant;
use App\Models\Schedule;
use DateTime;
use Illuminate\Support\Facades\Log;

class ProjectController extends BaseController
{
    public function __construct(Applicant $model)
    {
        parent::__construct($model);
    }

    public function projectsForm(?int $selected = null)
    {
        $nrp = strtolower('c14210206');
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

        $now = (new DateTime('now', new \DateTimeZone('Asia/Jakarta')))->getTimestamp();
        $data['passedDeadline'] = $now > $this->getProjectDeadline($applicant, $nrp, $selected);
        $data['projectDescription'] = ($now > $this->getInterviewStartTimestamp($applicant, $nrp, $selected))
            ? $applicant['priority_division' . $selected]['project']
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

    private function getInterviewStartTimestamp($applicant, $nrp, $selectedPriority)
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

    private function getProjectDeadline($applicant, $nrp, $selectedPriority)
    {
        $interviewStartTimestamp = $this->getInterviewStartTimestamp($applicant, $nrp, $selectedPriority);
        $interval = $applicant['priority_division' . $selectedPriority]['project_deadline'];
        $projectDeadline = $interviewStartTimestamp + $interval;

        return $projectDeadline;
    }
}
