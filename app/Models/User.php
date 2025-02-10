<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // public $id;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'emp_id',
        'division',
        'unit',
        'province',
        'region',
        'groups',
        'roles',
        'firstname',
        'middlename',
        'lastname',
        'gender',
        'position',
        'emp_type',
        'username',
        'email',
        'password',
        'address',
        'mobile_no',
        'last_login',
        'is_active',
        'current_team_id',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */

    //  public function upadateuser(int $update_user_id)
    //  {
    //     $user = User::find($update_user_id);
    //     if($user){
    //         $this->update_user_id = $user->id;
    //     }else{
    //         return redirect()->route('users.index')->with('success', 'User updated successfully.');
    //     }
    // }

    // If a user belongs to a team, you can define this relationship.
    public function team()
    {
        return $this->belongsTo(Team::class, 'current_team_id');
    }
}
