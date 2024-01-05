<?php

namespace App\Models;

use App\Models\ModelUtils;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Schedule extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
        'date_id',
        'time',
        'admin_id',
        'status',
        'type',
        'applicant_id'
    ]; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden=[
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
            'date_id' => 'required|uuid|exists:dates,id',
            'time' => 'required|integer|min:0|max:23',
            'admin_id' => 'required|uuid|exists:admins,id',
            'status' => 'required|integer|min:0|max:2',
            'type' => 'integer|min:0|max:2',
            'applicant_id' => 'uuid|exists:applicants,id',
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
            'date_id.required' => 'Date is required',
            'date_id.uuid' => 'Date must be a uuid',
            'date_id.exists' => 'Date must be exists',
            'time.required' => 'Time is required',
            'time.integer' => 'Time must be an integer',
            'time.min' => 'Time must be at least 0',
            'time.max' => 'Time must be at most 23',
            'admin_id.required' => 'Admin is required',
            'admin_id.uuid' => 'Admin must be a uuid',
            'admin_id.exists' => 'Admin must be exists',
            'status.required' => 'Status is required',
            'status.integer' => 'Status must be an integer',
            'status.min' => 'Status must be at least 0',
            'status.max' => 'Status must be at most 2',
            'type.integer' => 'Type must be an integer',
            'type.min' => 'Type must be at least 0',
            'type.max' => 'Type must be at most 2',
            'applicant_id.uuid' => 'Applicant must be a uuid',
            'applicant_id.exists' => 'Applicant must be exists',
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
            'date_id' => $request->date_id,
            'time' => $request->time,
            'admin_id' => $request->admin_id,
            'status' => $request->status,
            'type' => $request->type,
            'applicant_id' => $request->applicant_id,
        ]);
    }


    /**
     * Controller associated with this model
     *
     * @var string
     */

    public function controller()
    {
        return 'App\Http\Controllers\ScheduleController';
    }

    /**
    * Relations associated with this model
    *
    * @var array
    */
    public function relations()
    {
        return ['admin', 'date','applicant'];
    }

    /**
    * Space for calling the relations
    *
    *
    */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function date()
    {
        return $this->belongsTo(Date::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
