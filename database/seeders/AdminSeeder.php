<?php

namespace Database\Seeders;
use App\Models\Admin;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        Admin::create([
            'emo_name' => 'admin',
            'email' => 'admin@gmail.com',
            'emp_address' => 'null',
            'emp_mobile_no' => 'null',
            'emp_document' => 'null',
            'emp_bank_document' => 'null',
            'emp_department_name' => 'null',
            'joining_date' => 'null',
            'emp_birthday_date' => 'null',
            'emp_notes' => 'null',
            'password' => bcrypt('123456'),
            'role' => 0,
            'is_lock' => 0
        ]);
    }
}
