<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users_tbl'; 
    
    
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
       'email',
       'password',
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
           'email' => 'required',
           'password' => 'required',
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
           'email.required'    => 'Um endereço de email precisa ser informado',
           'password.required'    => 'Uma senha precissa ser informada',
       ];
   }
}
