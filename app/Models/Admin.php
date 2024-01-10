<?php

namespace App\Models;

use App\Models\ModelUtils;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Admin extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
        'email',
        'name',
        'line',
        'meet',
        'spot',
        'division_id'
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
            'email' => 'required|string|max:50',
            'name' => 'required|string|max:50',
            'line' => 'required|string|max:20',
            'meet' => 'nullable|string|max:255',
            'spot' => 'nullable|string|max:255', // 'nullable|string|max:255
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
            'email.required' => 'email is required!',
            'email.string' => 'email must be string!',
            'email.max' => 'email max 50 characters!',
            'name.required' => 'name is required!',
            'name.string' => 'name must be string!',
            'name.max' => 'name max 50 characters!',
            'line.required' => 'line is required!',
            'line.string' => 'line must be string!',
            'line.max' => 'line max 20 characters!',
            'meet.string' => 'meet must be string!',
            'meet.max' => 'meet max 255 characters!',
            'spot.string' => 'spot must be string!',
            'spot.max' => 'spot max 255 characters!',
            'division_id.required' => 'division_id is required!',
            'division_id.uuid' => 'division_id must be uuid!',
            'division_id.exists' => 'division_id must be exists!',
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
            'email' => $request->email,
            'name' => $request->name,
            'line' => $request->line,
            'meet' => $request->meet,
            'spot' => $request->spot,
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
        return 'App\Http\Controllers\AdminController';
    }

    /**
    * Relations associated with this model
    *
    * @var array
    */
    public function relations()
    {
        return [
            'schedules',
            'division',
        ];
    }

    /**
    * Space for calling the relations
    *
    *
    */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
