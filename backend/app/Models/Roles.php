<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Roles extends Model
{
    
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'role_id'; 
    protected $fillable = ['name', 'slug', 'description', 'is_system', 'level'];
    protected $casts = [
        'is_system' => 'boolean'
    ];

    public function users() {
        return $this->belongsToMany(Users::class, 'role_user' , 'role_id', 'user_id' )
                    ->withPivot('assigned_by')
                    ->withTimestamps();
    }

    public function permission() {
        return $this->belongsToMany(Permissions::class , 'role_permission' , 'role_id' , 'permission_id')
                    ->withPivot('granted_by')
                    ->withTimestamps();
    }

    public function givePermissionTo ($permission) {
        if(is_string($permission)){
            $permission = Permissions::where('slug' , $permission)->firstOrFail();
        }
        return $this->permission()->syncWithoutDetaching([
            $permission->permission_id => ['granted_by' => Auth::id()]
        ]);
    }

    public function revokePermissionTo($permission) {
        if(is_string($permission)){
            $permission = Permissions::where('slug' , $permission)->firstOrFail();
        };

        return $this->permission()->detach($permission->permission_id);
    }
}
 