<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsOrganizer extends Model
{
    use HasFactory;

    protected $table = 'events_organizer_tbl';

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
        'users_id',
        'date_init_event',
        'date_end_event',
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
            'users_id' => 'required',
            'date_init_event' => 'required',
            'date_end_event' => 'required',
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
            'users_id.required'    => 'users_id não foi referênciado',
            'date_init_event.required'    => 'date_init_event não informado',
            'date_end_event.required'    => 'date_end_event não informado',
        ];
    }
}
