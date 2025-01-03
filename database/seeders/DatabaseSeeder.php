<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartmentSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(leave_typeSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(CountriesTableSeeder::class);
    }
}
