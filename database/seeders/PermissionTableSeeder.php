<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
        ];
        
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
       
        $role = Role::create(['name' => 'superadmin']);


        $input = [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' =>  Hash::make('admin'),
        ];
    
       
    
        $user = User::create($input);
        $role = ['superadmin']; 
        $user->assignRole($role);

    }
}
