<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'emp_id',
        'firstname',
        'middlename',
        'lastname',
        'gender',
        'id_position',
        'id_division_unit',
        'emp_type',
        'roles',
        'username',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'id_position');
    }

    public function divisionUnit()
    {
        return $this->belongsTo(DivisionUnit::class, 'id_division_unit');
    }
}
