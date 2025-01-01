<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('emo_name')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->string('emp_address')->nullable();
            $table->string('emp_mobile_no')->nullable();
            $table->string('emp_document')->nullable();
            $table->string('emp_bank_document')->nullable();
            $table->string('emp_department_name')->nullable();
            $table->string('joining_date')->nullable();
            $table->string('emp_birthday_date')->nullable();
            $table->string('emp_notes')->nullable();
            $table->string('role')->nullable()->comment('0 is admin 1 is team head , 2 is employee , 3 is HR');
            $table->string('is_lock')->default('0')->comment('0 is unclock 1 is lock');
            $table->string('is_deleted')->default('0')->comment('0 is not deleted 1 is deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
