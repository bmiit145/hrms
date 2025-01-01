<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThreeColumnToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('emp_father_mobile_no')->after('emp_address')->nullable();
            $table->string('emp_mother_mobile_no')->after('emp_father_mobile_no')->nullable();
            $table->string('emp_brother_sister_mobile_no')->after('emp_mother_mobile_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('emp_father_mobile_no');
            $table->dropColumn('emp_mother_mobile_no');
            $table->dropColumn('emp_brother_sister_mobile_no');
        });
    }
}
