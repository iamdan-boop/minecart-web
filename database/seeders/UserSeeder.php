<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = User::factory(10)->create();
        foreach ($users as $user) {
            $user->assignRole(User::$ROLE_USER)
                ->deposit(9999);
        }

        $bantays = User::factory(10)->create();
        foreach ($bantays as $bantay) {
            $bantay->assignRole(User::$ROLE_BANTAY)
                ->deposit(9999);
        }


        $admins = User::factory(5)->create();
        foreach ($admins as $admin) {
            $admin->assignRole(User::$ROLE_ADMIN)
                ->deposit(999);
        }
    }
}
