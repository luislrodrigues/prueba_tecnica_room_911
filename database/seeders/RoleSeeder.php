<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(Role::ROLES); $i++) {
            Role::create([
                'id'    => $i+1,
                'name'  => Role::ROLES[$i],
            ]);
        }

    }
}
