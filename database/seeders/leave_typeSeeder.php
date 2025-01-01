<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\leave_type;
use Illuminate\Support\Facades\DB;

class leave_typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        leave_type::truncate();

        $name = [
            ['id' => 1, 'leave_type' => 'Casual Leave'],
            ['id' => 2, 'leave_type' => 'Emergency Leave'],
            ['id' => 3, 'leave_type' => 'Family Leave'],
            ['id' => 4, 'leave_type' => 'Sick Leave'],
            ['id' => 5, 'leave_type' => 'Medical leave'],
            ['id' => 6, 'leave_type' => 'Maternity Leave'],
            ['id' => 7, 'leave_type' => 'Marriage leave'],
        ];
    
        DB::table('leave_types')->insert($name);
    }
}
