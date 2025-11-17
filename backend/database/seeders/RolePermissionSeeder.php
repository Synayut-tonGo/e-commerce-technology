<?php

namespace Database\Seeders;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    use HasFactory;

    public function run(): void
    {
        //

        $permissions = [
            // User Management
            ['name' => 'Create User', 'slug' => 'users.create', 'group' => 'users'],
            ['name' => 'View User', 'slug' => 'users.view', 'group' => 'users'],
            ['name' => 'Edit User', 'slug' => 'users.edit', 'group' => 'users'],
            ['name' => 'Delete User', 'slug' => 'users.delete', 'group' => 'users'],
            
            // Product Management
            ['name' => 'Create Product', 'slug' => 'products.create', 'group' => 'products'],
            ['name' => 'View Product', 'slug' => 'products.view', 'group' => 'products'],
            ['name' => 'Edit Product', 'slug' => 'products.edit', 'group' => 'products'],
            ['name' => 'Delete Product', 'slug' => 'products.delete', 'group' => 'products'],
            
            // Sales Management
            ['name' => 'Create Sale', 'slug' => 'sales.create', 'group' => 'sales'],
            ['name' => 'View Sale', 'slug' => 'sales.view', 'group' => 'sales'],
            ['name' => 'Process Payment', 'slug' => 'sales.payment', 'group' => 'sales'],
            
            // Reports
            ['name' => 'View Reports', 'slug' => 'reports.view', 'group' => 'reports'],
            
            // Role & Permission Management
            ['name' => 'Manage Roles', 'slug' => 'roles.manage', 'group' => 'roles', 'is_system' => true],
            ['name' => 'Assign Permissions', 'slug' => 'permissions.assign', 'group' => 'permissions', 'is_system' => true],
        ];

        foreach($permissions as $permission){
            Permissions::create($permission);
        };

        $superAdmin = Roles::create([
            'name' => 'Super Admin',
            'slug' => 'super_admin',
            'description' => 'Full system access',
            'is_system' => true,
            'level'=> 100
        ]);

        $admin = Roles::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Dashboard and management access',
            'level' => 50
        ]);
        
        $cashier = Roles::create([
            'name' => 'Cashier',
            'slug' => 'cashier',
            'description' => 'Point of sale access',
            'level' => 20
        ]);
        
        $customer = Roles::create([
            'name' => 'Customer',
            'slug' => 'customer',
            'description' => 'E-commerce customer access',
            'level' => 10
        ]);
        
        // Assign Permissions to Roles
        // Super Admin gets all permissions
        $superAdmin->permission()->attach(Permissions::all());
        
        // Admin gets most permissions except role/permission management
        $admin->permission()->attach(
            Permissions::whereNotIn('group', ['roles', 'permissions'])->pluck('permission_id')
        );
        
        // Cashier gets sales-related permissions
        $cashier->permission()->attach(
            Permissions::where('group', 'sales')
                      ->orWhere('slug', 'products.view')
                      ->pluck('permission_id')
        );
        
        // Customer gets basic view access
        $customer->permission()->attach(
            Permissions::where('slug', 'products.view')->pluck('permission_id')
        );        

    }
}
