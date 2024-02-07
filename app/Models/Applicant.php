<?php

namespace App\Models;

use App\Models\ModelUtils;
use App\Rules\AstorDivisionRule;
use App\Rules\MinimumGpaRule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Applicant extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'email',
        'major_id',
        'gender',
        'religion',
        'birthplace',
        'birthdate',
        'province',
        'city',
        'address',
        'postal_code',
        'phone',
        'line',
        'instagram',
        'tiktok',
        'gpa',
        'motivation',
        'commitment',
        'strength',
        'weakness',
        'experience',
        'diet',
        'allergy',
        'medical_history',
        'astor',
        'priority_division1',
        'priority_division2',
        'division_accepted',
        'documents',
        'schedule_id',
        'stage'
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

    protected $casts = ['documents' => 'array', 'medical_history' => 'array'];

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
            'major_id' => 'required|uuid|exists:majors,id',
            'gender' => 'required|boolean',
            'religion' => 'required|string|max:30',
            'birthplace' => 'required|string|max:50',
            'birthdate' => 'required|date|date_format:Y-m-d',
            'province' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:5',
            'phone' => 'required|string|regex:/^([0-9]{8,16})$/',
            'line' => 'required|string|max:50',
            'instagram' => 'required|string|max:50',
            'tiktok' => 'nullable|string|max:50',
            'gpa' => ['required', 'string', 'regex:/^(4\.00|[0-3]\.[0-9]{2})$/', new MinimumGpaRule],
            'motivation' => 'required|string',
            'commitment' => 'required|string',
            'strength' => 'required|string',
            'weakness' => 'required|string',
            'experience' => 'nullable|string',
            'diet' => 'required|string|max:50',
            'allergy' => 'nullable|string|max:150',
            'medical_history' => 'required|required_array_keys:other_disease,disease_explanation,medication_allergy',
            'medical_history.other_disease' => 'required|string',
            'medical_history.disease_explanation' => 'required|string',
            'medical_history.medication_allergy' => 'required|string',
            'astor' => 'required|boolean',
            'priority_division1' => ['required', 'uuid', 'exists:divisions,id', new AstorDivisionRule],
            'priority_division2' => ['nullable', 'uuid', 'exists:divisions,id', 'different:priority_division1', new AstorDivisionRule],
            'division_accepted' => 'nullable|uuid|exists:divisions,id',
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|string|max:255',
            'schedule_id' => 'nullable|uuid|exists:schedules,id',
            'stage' => 'required|integer'
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
            'major_id.required' => 'Major is required',
            'major_id.uuid' => 'Major must be a uuid',
            'major_id.exists' => 'Major must be exists',
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
            'phone.regex' => 'Phone must be a valid phone number',
            'line.required' => 'Line is required',
            'line.string' => 'Line must be a string',
            'line.max' => 'Line must be less than 50 characters',
            'instagram.required' => 'Instagram is required',
            'instagram.string' => 'Instagram must be a string',
            'instagram.max' => 'Instagram must be less than 50 characters',
            'tiktok.string' => 'TikTok must be a string',
            'tiktok.max' => 'TikTok must be less than 50 characters',
            'gpa.required' => 'GPA is required',
            'gpa.string' => 'GPA must be a string',
            'gpa.regex' => 'GPA format is invalid, valid format example: 3.78',
            'motivation.required' => 'Motivation is required',
            'motivation.string' => 'Motivation must be a string',
            'commitment.required' => 'Commitment is required',
            'commitment.string' => 'Commitment must be a string',
            'strength.required' => 'Strength is required',
            'strength.string' => 'Strength must be a string',
            'weakness.required' => 'Weakness is required',
            'weakness.string' => 'Weakness must be a string',
            'experience.string' => 'Experience must be a string',
            'diet.required' => 'Diet is required',
            'diet.string' => 'Diet must be a string',
            'diet.max' => 'Diet must be less than 50 characters',
            'allergy.string' => 'Allergy must be a string',
            'allergy.max' => 'Allergy must be less than 150 characters',
            'medical_history.required' => 'Medical history is required',
            'medical_history.required_array_keys' => 'Medical history is required',
            'medical_history.other_disease.required' => 'Other disease is required',
            'medical_history.other_disease.string' => 'Other disease must be a string',
            'medical_history.disease_explanation.required' => 'Disease explanation is required',
            'medical_history.disease_explanation.string' => 'Disease explanation must be a string',
            'medical_history.medication_allergy.required' => 'Medication allergy is required',
            'medical_history.medication_allergy.string' => 'Medication allergy must be a string',
            'astor.required' => 'Astor is required',
            'astor.boolean' => 'Astor must be a boolean',
            'division_priority1.required' => 'Division priority1 is required',
            'division_priority1.uuid' => 'Division priority1 must be a uuid',
            'division_priority1.exists' => 'Division priority1 must be exists',
            'division_priority2.uuid' => 'Division priority2 must be a uuid',
            'division_priority2.exists' => 'Division priority2 must be exists',
            'division_priority2.different' => 'Please empty division priority2 if you choose the same division',
            'division_accepted.uuid' => 'Division accepted must be a uuid',
            'division_accepted.exists' => 'Division accepted must be exists',
            'documents.array' => 'Documents must be an array',
            'documents.*.string' => 'Documents must be a string',
            'documents.*.max' => 'Documents must be less than 255 characters',
            'schedule_id.uuid' => 'Schedule must be a uuid',
            'schedule_id.exists' => 'Schedule must be exists',
            'stage.required' => 'Stage is required',
            'stage.integer' => 'Stage must be an Integer',
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
        return ['major', 'priorityDivision1', 'priorityDivision2', 'divisionAccepted', 'answers', 'schedules', 'diseases'];
    }

    /**
     * Space for calling the relations
     *
     *
     */
    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

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

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function diseases()
    {
        return $this->belongsToMany(Disease::class);
    }

    public function getNRP()
    {
        $explodedEmail = explode('@', $this->email);
        return strtolower($explodedEmail[0]);
    }

    public function addDocument($documentType, $filename)
    {
        $documents = $this->documents;

        if (!$documents) $documents = [];

        $documents[$documentType] = $filename;
        $this->documents = $documents;
        $this->save();
    }

    public function addProject($project, $priority)
    {
        $documents = $this->documents;

        if (!isset($documents['projects'])) $documents['projects'] = [];
        $documents['projects'][$priority] = $project;
        $this->documents = $documents;
        $this->save();
    }

    public function addDiseases($diseaseIds)
    {
        $this->diseases()->attach($diseaseIds);
    }

    public function findByEmail($email, array $columns = ['*'], $relations = null)
    {
        $builder = $relations ? $this->with($relations) : $this;
        return $builder->select(...$columns)
            ->where('email', $email)
            ->first();
    }

    public function findByNRP($nrp, array $columns = ['*'], $relations = null)
    {
        return $this->findByEmail($nrp . '@john.petra.ac.id', $columns, $relations);
    }

    public function cv()
    {
        $this->load($this->relations());
        return Pdf::loadView(
            'pdf.applicant_cv',
            ['applicant' => $this]
        );
    }
}
