<?php

namespace App\Models;

use App\Models\ModelUtils;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
        'number',
        'question',
        'description',
        'division_id',
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
            'number' => 'required|integer',
            'question' => 'required|string',
            'description' => 'nullable|string',
            'division_id' => 'required|uuid|exists:divisions,id',
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
            'number.required' => 'Number is required',
            'number.integer' => 'Number must be an integer',
            'question.required' => 'Question is required',
            'question.string' => 'Question must be a string',
            'description.string' => 'Description must be a string',
            'division_id.required' => 'Division is required',
            'division_id.uuid' => 'Division must be a valid uuid',
            'division_id.exists' => 'Division must be an existing division',
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
            'number' => $request->number,
            'question' => $request->question,
            'description' => $request->description,
            'division_id' => $request->division_id,
        ]);
    }


    /**
     * Controller associated with this model
     *
     * @var string
     */

    public function controller()
    {
        return 'App\Http\Controllers\QuestionController';
    }

    /**
    * Relations associated with this model
    *
    * @var array
    */
    public function relations()
    {
        return ['division'];
    }

    /**
    * Space for calling the relations
    *
    *
    */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
