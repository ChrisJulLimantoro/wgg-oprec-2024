<?php

namespace App\Models;

use App\Models\ModelUtils;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Major extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'english_name', 'code', 'faculty_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden;

    /**
     * Rules that applied in this model
     *
     * @var array
     */
    public static function validationRules()
    {
        return [];
    }

    /**
     * Messages that applied in this model
     *
     * @var array
     */
    public static function validationMessages()
    {
        return [];
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
        return 'App\Http\Controllers\MajorController';
    }

    /**
     * Relations associated with this model
     *
     * @var array
     */
    public function relations()
    {
        return ['faculty'];
    }

    /**
     * Space for calling the relations
     *
     *
     */

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
