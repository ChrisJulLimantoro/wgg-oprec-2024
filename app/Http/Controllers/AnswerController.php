<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Question;
use App\Models\Applicant;
use App\Models\Answer;
use App\Models\Division;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AnswerController extends BaseController
{
    private $question;
    private $applicant;
    private $division;
    private $schedule;
    public function __construct(Answer $model)
    {
        parent::__construct($model);
        $this->question = new Question();
        $this->applicant = new Applicant();
        $this->division = new Division();
        $this->schedule = new Schedule();
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
    public function getQuestion($schedule_id,$page=0)
    {
        $page = intval($page);

        // Fetch Interview Schedule information
        $schedule = Schedule::with(['applicant.priorityDivision1','applicant.priorityDivision2','applicant.answers'])->where('id',$schedule_id)->first();
        $applicant = $schedule->applicant;
        $type = $schedule->type;
        // dd($applicant->priority_division2);
        if($applicant == null || $schedule == null){
            return view('errors.404');
        }else{
            $applicant = $applicant->toArray();
            $questions = [];
            $divisions = [];
            $part = [];
            $count = 0;
            // pertanyaan pembuka hanya jika tipenya bukan 2
            if($type != 2){
                if($type == 0){
                    if($applicant['priority_division2'] == null){
                        $divisions = [$applicant['priority_division1']];
                    }else{
                        if($applicant['priority_division1'] != $applicant['priority_division2']){
                            $divisions = [$applicant['priority_division1'],$applicant['priority_division2']];
                        }else{
                            $divisions = [$applicant['priority_division1']];
                        }
                    }
                }else{
                    $divisions = [$applicant['priority_division1']];
                }
                $part[] = 'Opening';
                // Get Opening Question
                $opening = Question::where(['division_id' => Division::where(['slug' => 'open'])->first()->id])
                ->orderBy('number','asc')
                ->get()
                ->toArray();
                $questions[$count] = $opening;
                $count += 1;
            }else{
                $divisions = [$applicant['priority_division2']];
            }
            // Get Questions
            foreach($divisions as $division){
                $questions[$count] = Question::where(['division_id' => $division['id']])
                ->orderBy('number','asc')
                ->get()
                ->toArray();
                $part[] = $division['name'];
                $count += 1;
            }

            // pertanyaan penutup hanya jika tipenya bukan 2
            if($type != 2){
                // Get Closing Question
                $closing = Question::where(['division_id' => Division::where(['slug' => 'close'])->first()->id])
                ->orderBy('number','asc')
                ->get()
                ->toArray();
                $questions[$count] = $closing;
                $part[] = 'Closing';
                $count += 1;
            }
            $answers = $applicant['answers'];
            
            $data['part'] = $part[$page];
            foreach($questions[$page] as $q){
                $q['answered'] = false;
                foreach($answers as $answer){
                    if($answer['question_id'] == $q['id']){
                        $q['answered'] = true;
                        $q['answer'] = $answer['answer'];
                        $q['answer_id'] = $answer['id'];
                        $q['score'] = $answer['score'];
                        break;
                    }
                }
                $data['questions'][] = $q;
            }
            $count -= 1;
            $data['title'] = 'Interview page '.$page.' of '.$count;
            $data['next'] = $page < $count;
            $data['prev'] = $page > 0;
            $data['now'] = $page;
            $data['applicant'] = $applicant['id'];
            $data['schedule'] = $schedule_id;
            
            foreach($divisions as $d){
                if($d['project'] == null){
                    $data['project'][] = ['name' => $d['name'],'project' => 'No Project'];
                }
            }
            
            // dd($data,$count,$questions,$part);
            return view('admin.interview.interview', $data);
        }
    }

    // Submit Answer First
    public function submitAnswer(Request $request)
    {
        $request->merge(['score' => 0]);
        $err = $this->store($request);
        if(isset($err['error'])){
            return response()->json(['success' => false,'message' => $err['error']->first()]);
        }
        return response()->json(['success' => true, 'message' => 'Answer Submitted Successfully!!','answer_id' => $err['id']]);
    }

    // Submit Score First
    public function submitScore(Request $request)
    {
        $request->merge(['answer' => 'Answer goes here ...']);
        $err = $this->store($request);
        if(isset($err['error'])){
            return response()->json(['success' => false,'message' => $err['error']->first()]);
        }
        return response()->json(['success' => true, 'message' => 'Score Submitted Successfully!!','answer_id' => $err['id']]);
    }

    // update Answer
    public function updateAnswer(Request $request)
    {
        $res = $this->updatePartial($request->only(['answer']),$request->only(['answer_id']));
        if(isset($res['error'])){
            return response()->json(['success' => false,'message' => $res['error']]);
        }
        return response()->json(['success' => true, 'message' => 'Answer Updated Successfully!!']);
    }

    // update Score
    public function updateScore(Request $request)
    {
        $res = $this->updatePartial($request->only(['score']),$request->only(['answer_id']));
        if(isset($res['error'])){
            return response()->json(['success' => false,'message' => $res['error']]);
        }
        return response()->json(['success' => true, 'message' => 'Score Updated Successfully!!']);
    }

    // not done project
    public function addProject(Request $request)
    {
        return response()->json(['success' => false, 'message' => 'Project Not Done Yet!!']);
    }

    // not done interview
    public function finish(Request $request)
    {
        return response()->json(['success' => false, 'message' => 'Interview Not Finished Yet!!']);
    }
}