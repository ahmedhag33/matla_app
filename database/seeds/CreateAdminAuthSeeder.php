<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CreateAdminAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // set the role id
        $roleId = null;
        // set the admin password
        $password = "J5nmYjM[5<J&]L,[)#i";
        // check if admin user already exists
        if (!in_array('ADMIN', Role::pluck('code')->toArray())) {
            // create the admin user
            $roleCreate = Role::create([
                'code' => 'ADMIN',
                'name' => 'المدير',
            ]);
            $roleId = $roleCreate->id;
        } else {
            // get the role with code 'ADMIN'
            $role = Role::where('code', 'ADMIN')->first();
            // set the role id for the admin user
            $roleId = $role->id;
        }
        // create the admin user
        Admin::create([
            'name' => 'مدير النظام',
            'email' => 'admin@localhost.com',
            'password' => createHash($password),
            'role_id' => $roleId,
        ]);
    }
}
