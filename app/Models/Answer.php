<?php

namespace App\Models;

use App\Models\ModelUtils;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Answer extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer',
        'question_id',
        'applicant_id',
        'score'
    ]; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];  

    /**
     * Rules that applied in this model
     *
     * @var array
     */
    public static function validationRules()
    {
        return [
            'answer' => 'required|string',
            'question_id' => 'required|uuid|exists:questions,id',
            'applicant_id' => 'required|uuid|exists:applicants,id',
            'score' => 'required|integer',
        ];
    }

    /**
     * Messages that applied in this model
     *
     * @var array
     */
    public static function validationMessages()
    {
        return [
            'answer.required' => 'Answer is required!',
            'answer.string' => 'Answer must be a string!',
            'question_id.required' => 'Question is required!',
            'question_id.uuid' => 'Question must be a uuid!',
            'question_id.exists' => 'Question must be exists!',
            'applicant_id.required' => 'Applicant is required!',
            'applicant_id.uuid' => 'Applicant must be a uuid!',
            'applicant_id.exists' => 'Applicant must be exists!',
            'score.required' => 'Score is required!',
            'score.integer' => 'Score must be an integer!',
        ];
    }

    /**
     * Filter data that will be saved in this model
     *
     * @var array
     */
    public function resourceData($request)
    {
        return ModelUtils::filterNullValues([
            'answer' => $request->answer,
            'question_id' => $request->question_id,
            'applicant_id' => $request->applicant_id,
            'score' => $request->score,
        ]);
    }


    /**
     * Controller associated with this model
     *
     * @var string
     */

    public function controller()
    {
        return 'App\Http\Controllers\AnswerController';
    }

    /**
    * Relations associated with this model
    *
    * @var array
    */
    public function relations()
    {
        return ['question', 'applicant'];
    }

    /**
    * Space for calling the relations
    *
    *
    */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

}
