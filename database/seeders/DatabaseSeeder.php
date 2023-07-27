<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

