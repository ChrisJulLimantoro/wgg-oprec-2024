<?php

namespace App\Models;

use App\Models\ModelUtils;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Applicant extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

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

    protected $casts = ['documents' => 'array'];

    /**
     * Rules that applied in this model
     *
     * @var array
     */
    public static function validationRules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:50',
            'gender' => 'required|boolean',
            'religion' => 'required|string|max:30',
            'birthplace' => 'required|string|max:50',
            'birthdate' => 'required|date',
            'province' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:5',
            'phone' => 'required|string|max:15',
            'line' => 'nullable|string|max:50',
            'instagram' => 'nullable|string|max:50',
            'tiktok' => 'nullable|string|max:50',
            'gpa' => 'required|string|max:4',
            'motivation' => 'required|string',
            'commitment' => 'required|string',
            'strength' => 'required|string',
            'weakness' => 'required|string',
            'experience' => 'required|string',
            'diet' => 'required|string|max:50',
            'allergy' => 'nullable|string|max:150',
            'astor' => 'required|boolean',
            'priority_division1' => 'required|uuid|exists:divisions,id',
            'priority_division2' => 'nullable|uuid|exists:divisions,id',
            'division_accepted' => 'nullable|uuid|exists:divisions,id',
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|string|max:255',
            'schedule_id' => 'nullable|uuid|exists:schedules,id',
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
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 100 characters',
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email.email' => 'Email must be a valid email address',
            'email.max' => 'Email must be less than 50 characters',
            'gender.required' => 'Gender is required',
            'gender.boolean' => 'Gender must be a boolean',
            'religion.required' => 'Religion is required',
            'religion.string' => 'Religion must be a string',
            'religion.max' => 'Religion must be less than 30 characters',
            'birthplace.required' => 'Birthplace is required',
            'birthplace.string' => 'Birthplace must be a string',
            'birthplace.max' => 'Birthplace must be less than 50 characters',
            'birthdate.required' => 'Birthdate is required',
            'birthdate.date' => 'Birthdate must be a date',
            'province.required' => 'Province is required',
            'province.string' => 'Province must be a string',
            'province.max' => 'Province must be less than 50 characters',
            'city.required' => 'City is required',
            'city.string' => 'City must be a string',
            'city.max' => 'City must be less than 50 characters',
            'address.required' => 'Address is required',
            'address.string' => 'Address must be a string',
            'postal_code.required' => 'Postal code is required',
            'postal_code.string' => 'Postal code must be a string',
            'postal_code.max' => 'Postal code must be less than 5 characters',
            'phone.required' => 'Phone is required',
            'phone.string' => 'Phone must be a string',
            'phone.max' => 'Phone must be less than 15 characters',
            'line.string' => 'Line must be a string',
            'line.max' => 'Line must be less than 50 characters',
            'instagram.string' => 'Instagram must be a string',
            'instagram.max' => 'Instagram must be less than 50 characters',
            'tiktok.string' => 'TikTok must be a string',
            'tiktok.max' => 'TikTok must be less than 50 characters',
            'gpa.required' => 'GPA is required',
            'gpa.string' => 'GPA must be a string',
            'gpa.max' => 'GPA must be less than 4 characters',
            'motivation.required' => 'Motivation is required',
            'motivation.string' => 'Motivation must be a string',
            'commitment.required' => 'Commitment is required',
            'commitment.string' => 'Commitment must be a string',
            'strength.required' => 'Strength is required',
            'strength.string' => 'Strength must be a string',
            'weakness.required' => 'Weakness is required',
            'weakness.string' => 'Weakness must be a string',
            'experience.required' => 'Experience is required',
            'experience.string' => 'Experience must be a string',
            'diet.required' => 'Diet is required',
            'diet.string' => 'Diet must be a string',
            'diet.max' => 'Diet must be less than 50 characters',
            'allergy.string' => 'Allergy must be a string',
            'allergy.max' => 'Allergy must be less than 150 characters',
            'astor.required' => 'Astor is required',
            'astor.boolean' => 'Astor must be a boolean',
            'division_priority1.required' => 'Division priority1 is required',
            'division_priority1.uuid' => 'Division priority1 must be a uuid',
            'division_priority1.exists' => 'Division priority1 must be exists',
            'division_priority2.uuid' => 'Division priority2 must be a uuid',
            'division_priority2.exists' => 'Division priority2 must be exists',
            'division_accepted.uuid' => 'Division accepted must be a uuid',
            'division_accepted.exists' => 'Division accepted must be exists',
            'documents.array' => 'Documents must be an array',
            'documents.*.string' => 'Documents must be a string',
            'documents.*.max' => 'Documents must be less than 255 characters',
            'schedule_id.uuid' => 'Schedule must be a uuid',
            'schedule_id.exists' => 'Schedule must be exists',
        ];
    }

    /**
     * Filter data that will be saved in this model
     *
     * @var array
     */
    public function resourceData($request)
    {
        return ModelUtils::filterNullValues([]);
    }


    /**
     * Controller associated with this model
     *
     * @var string
     */

    public function controller()
    {
        return 'App\Http\Controllers\ApplicantController';
    }

    /**
    * Relations associated with this model
    *
    * @var array
    */
    public function relations()
    {
        return ['priorityDivision1','priorityDivision2','divisionAccepted','answers','schedule'];
    }

    /**
    * Space for calling the relations
    *
    *
    */
    public function priorityDivision1()
    {
        return $this->belongsTo(Division::class, 'priority_division1');
    }

    public function priorityDivision2()
    {
        return $this->belongsTo(Division::class, 'priority_division2');
    }

    public function divisionAccepted()
    {
        return $this->belongsTo(Division::class, 'division_accepted');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
