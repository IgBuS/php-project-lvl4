<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    /**
     * The tasks that created by the user.
     *  @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasksCreatedBy()
    {
        return $this->hasMany(Task::class, 'created_by_id');
    }

    /**
     * The tasks that assigned by the user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasksAssignedTo()
    {
        return $this->hasMany(Task::class, 'assigned_to_id');
    }
}
