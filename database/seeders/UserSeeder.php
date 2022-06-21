<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id'=> Role::first()['id'],
            'name'=> 'Admin',
            'email'=> 'admin@admin.com',
            'password'=> bcrypt('1234admin'),
        ]);
    }
}
