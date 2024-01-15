<?php

namespace App\Models;

use App\Models\ModelUtils;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Setting extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
        'key',
        'value',
        'description',
    ]; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden=[
        'created_at',
        'updated_at',
    ];

    /**
     * Rules that applied in this model
     *
     * @var array
     */
    public static function validationRules()
    {
        return [
            'key' => 'required|string|max:255',
            'value' => 'required|integer',
            'description' => 'nullable|string|max:255',
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
            'key.required' => 'Key is required',
            'key.string' => 'Key must be string',
            'key.max' => 'Key max 255 characters',
            'value.required' => 'Value is required',
            'value.integer' => 'Value must be integer',
            'description.string' => 'Description must be string',
            'description.max' => 'Description max 255 characters',
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
            'key' => $request->key,
            'value' => $request->value,
            'description' => $request->description,
        ]);
    }


    /**
     * Controller associated with this model
     *
     * @var string
     */

    public function controller()
    {
        return 'App\Http\Controllers\SettingController';
    }

    /**
    * Relations associated with this model
    *
    * @var array
    */
    public function relations()
    {
        return [];
    }

    /**
    * Space for calling the relations
    *
    *
    */
}
