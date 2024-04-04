<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
        'role_id',
        'user_status_id',
        'provider_id',
        'provider',
        'provider_token',
    ];

    protected $primaryKey = 'user_id';
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

    public function returnUserName()
    {
        return $this->role_id;
    }

    public function getUserType()
    {
        // dd(config('permission'));
        $permission_mapping =  array_flip(config('permission'));

        return $permission_mapping[$this->role_id];
    }

    public function isAdminOrManager()
    {
        
        if($this->role_id == 2 or $this->role_id == 3) {
            return true;
        }
        return false;
        // dd('Xin chào');
    }
}
