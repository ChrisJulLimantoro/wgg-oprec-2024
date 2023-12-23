<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\DivisionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Question;
use App\Models\Division;

class QuestionController extends BaseController
{
    private $divisionController;
    public function __construct(Question $model)
    {
        parent::__construct($model);
        $this->divisionController = new DivisionController(new Division());
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
    public function index(){
        $data['divisions'] = $this->divisionController->getAll();
        $data['title'] = 'Interview Questions';
        return view('admin.interview.question', $data);
    }

    public function getQuestionByDept(Request $request){
        $data = $request->only(['division_id']);
        $questions = $this->getAll($data);
        return response()->json($questions);
    }

    public function addQuestion(Request $request){
        $data = $request->only(['question', 'description', 'division_id']);
        $validator = Validator::make($data, [
            'question' => 'required|string',
            'description' => 'nullable|string',
            'division_id' => 'required|uuid|exists:divisions,id',
        ], [
            'question.required' => 'Question is required',
            'question.string' => 'Question must be a string',
            'description.string' => 'Description must be a string',
            'division_id.required' => 'Division is required',
            'division_id.uuid' => 'Division must be a valid uuid',
            'division_id.exists' => 'Division must be an existing division',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false,'errors' => $validator->errors()], 400);
        }
        $number = $this->model->where('division_id', $data['division_id'])->pluck('number')->toArray();
        if(count($number) > 0){
            $number = max(array_values($number)) + 1;
        }else{
            $number = 1;
        }

        $request->merge(['number' => $number]);
        $question = $this->store($request);
        return response()->json(['success' => true,'id' => $question->id]);
    }

    public function updateQuestion(Request $request){
        $data = $request->only(['question', 'description', 'question_id']);
        $validator = Validator::make($data, [
            'question' => 'required|string',
            'description' => 'nullable|string',
            'question_id' => 'required|uuid|exists:questions,id',
        ], [
            'question.required' => 'Question is required',
            'question.string' => 'Question must be a string',
            'description.string' => 'Description must be a string',
            'question_id.required' => 'Question is required',
            'question_id.uuid' => 'Question must be a valid uuid',
            'question_id.exists' => 'Question must be an existing question',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false,'errors' => $validator->errors()], 400);
        }
        $question = $this->updatePartial($request->only(['question','description']), $data['question_id']);
        return response()->json(['success' => true]);
    }

    public function deleteQuestion(Request $request){
        $data = $request->only(['question_id']);
        $validator = Validator::make($data, [
            'question_id' => 'required|uuid|exists:questions,id',
        ], [
            'question_id.required' => 'Question is required',
            'question_id.uuid' => 'Question must be a valid uuid',
            'question_id.exists' => 'Question must be an existing question',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false,'errors' => $validator->errors()], 400);
        }
        $question = $this->delete($data['question_id']);
        return response()->json(['success' => true]);
    }
}