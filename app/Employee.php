<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use Notifiable;

    // protected $guard = 'employee';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'company_id',
        'email',
        'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
