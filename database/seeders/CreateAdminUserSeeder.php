<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin', 
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'roles_name' => ["owner"],
            'Status' => 'Active',
            ]);
      
            $role = Role::create(['name' => 'owner']);
       
            $permissions = Permission::pluck('id','id')->all();
      
            $role->syncPermissions($permissions);
       
            $user->assignRole([$role->id]);
    }
}
