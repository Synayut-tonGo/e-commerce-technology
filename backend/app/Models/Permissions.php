<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    //  
    use HasFactory;
    protected $table = "permissions";
    protected $primaryKey = 'permission_id';
    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'group', '
        is_system'
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];    

    public function roles() {
        return $this->belongsToMany(Roles::class, 'role_permission' , 'permission_is' , 'role_id')
                    ->withPivot('granted_by')
                    ->withTimestamps();
    }

}
