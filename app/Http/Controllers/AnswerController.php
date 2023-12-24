<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Question;
use App\Models\Applicant;
use App\Models\Answer;
use App\Models\Division;
use Illuminate\Http\Request;

class AnswerController extends BaseController
{
    private $question;
    private $applicant;
    private $division;
    public function __construct(Answer $model)
    {
        parent::__construct($model);
        $this->question = new Question();
        $this->applicant = new Applicant();
        $this->division = new Division();
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
    public function getQuestion($applicant_id,$page=0)
    {
        $page = intval($page);
        // Fetch applicant division
        $applicant = Applicant::with($this->applicant->relations())->where('id',$applicant_id)->first();  
        // dd($applicant->priority_division2);
        if($applicant == null){
            return view('errors.404');
        }else{
            $applicant = $applicant->toArray();
            if($applicant['priority_division2'] == null){
                $divisions = [$applicant['priority_division1']];
            }else{
                if($applicant['priority_division1'] != $applicant['priority_division2']){
                    $divisions = [$applicant['priority_division1'],$applicant['priority_division2']];
                }else{
                    $divisions = [$applicant['priority_division1']];
                }
            }
            $questions = [];
            $count = 0;
            $part = ['Opening'];
            // Get Opening Question
            $opening = Question::where(['division_id' => Division::where(['slug' => 'open'])->first()->id])
            ->orderBy('number','asc')
            ->get()
            ->toArray();
            $questions[$count] = $opening;
            $count += 1;
            // Get Questions
            foreach($divisions as $division){
                $questions[$count] = Question::where(['division_id' => $division['id']])
                ->orderBy('number','asc')
                ->get()
                ->toArray();
                $part[] = $division['name'];
                $count += 1;
            }
            // Get Closing Question
            $closing = Question::where(['division_id' => Division::where(['slug' => 'close'])->first()->id])
            ->orderBy('number','asc')
            ->get()
            ->toArray();
            $questions[$count] = $closing;
            $part[] = 'Closing';
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
            $data['title'] = 'Interview page '.$page.' of '.$count;
            $data['next'] = $page < $count;
            $data['prev'] = $page > 0;
            $data['now'] = $page;
            $data['applicant'] = $applicant_id;
            
            foreach($divisions as $d){
                if($d['project'] == null){
                    $data['project'][] = ['name' => $d['name'],'project' => 'No Project'];
                }
            }
            
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