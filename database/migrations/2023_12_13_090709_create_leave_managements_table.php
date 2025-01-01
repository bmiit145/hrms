<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_managements', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->string('leave_type')->nullable();
            $table->string('leave_reason')->nullable();
            $table->string('status')->nullable()->comment('0 is Rejected 1 is Approved');
            $table->string('user_delete')->default('0')->comment('0 is not delete 1 is delete');
            $table->string('admin_delete')->default('0')->comment('0 is not delete 1 is delete');
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
        Schema::dropIfExists('leave_managements');
    }
}
