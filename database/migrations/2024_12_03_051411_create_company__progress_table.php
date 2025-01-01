<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company__progress', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('amount')->nullable();
            $table->string('desc')->nullable();
            $table->string('progress_type')->comment('1 is income 2 is expense');
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
        Schema::dropIfExists('company__progress');
    }
}
