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
            'role_id'=> 1,
            'name'=> 'Admin',
            'email'=> 'admin@admin.com',
            'password'=> bcrypt('1234Ab'),
        ]);

        User::create([
            'role_id'=> 2,
            'name'=> 'Assistant',
            'email'=> 'assistant@email.com',
            'password'=> bcrypt('1234Ab'),
        ]);
    }
}
