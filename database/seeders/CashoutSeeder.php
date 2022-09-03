<?php

namespace Database\Seeders;

use App\Models\Cashout;
use Illuminate\Database\Seeder;

class CashoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Cashout::factory(100)->create();
    }
}
