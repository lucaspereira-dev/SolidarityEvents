<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsPictures extends Model
{
    use HasFactory;

    protected $table = 'events_pictures_tbl';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

     /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_creation';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'date_update';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'events_id',
        'pictures_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'events_id' => 'required',
            'pictures_id' => 'required',
        ];
    }


    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'events_id.required'    => 'events_id não foi referênciado',
            'pictures_id.required'    => 'pictures_id não foi referênciado',
        ];
    }
}
