<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     /** @var \App\Models\User $user */

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'dob',
        'age',
        'gender',
        'email',
        'password',
        'confirmation_password',
    ];

    protected $hidden = [
        'password',
        'confirmation_password',
        'remember_token',
    ];

    public function carts () {           // foreign key , local key
        return $this->hasOne(Carts::class, 'user_id' , 'user_id');
    }


    public function orders () {
        return $this->hasOne(Orders::class , 'user_id' , 'user_id');
    }

    public function roles () {
        return $this->belongsToMany(Roles::class , 'role_user' , 'user_id', 'role_id')
                    ->withPivot('assigned_by')
                    ->withTimestamps();
    }

    public function hasRole($roles){
        if(is_string($roles)){
            return $this->roles->contains('slug' , $roles);
        };

        return $this->roles-> contains($roles);
    }

    public function hasPermission($permission){
        return $this->roles->flatMap->permissions
                    ->contains('slug' , $permission);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
