<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department_name;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department_name::truncate();
        
        $name = [
            ['id' => 1, 'department_name' => 'PHP(Laravel) Department'],
            ['id' => 2, 'department_name' => 'Graphic Designer Department'],
            ['id' => 3, 'department_name' => 'Wordpress Department'],
            ['id' => 4, 'department_name' => 'Shopify Department'],
            ['id' => 5, 'department_name' => 'Project Coordinator Department'],
            ['id' => 6, 'department_name' => 'ui ux designer Department'],
            ['id' => 7, 'department_name' => 'HR Department'],
        ];
    
        DB::table('department_names')->insert($name);
    }
    
}
