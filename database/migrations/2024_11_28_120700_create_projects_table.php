<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name')->nullable();
            $table->string('amount')->nullable();
            $table->string('commission')->nullable();
            $table->string('text')->nullable();
            $table->string('total_earning')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('working_emp')->nullable();
            $table->string('payment')->comment('1 is milistone 2 is fix 3 is hourly')->nullable();
            $table->string('project_progress')->comment('0 is pendding 1 is working 2 is stack 3 is cancelled 4 is testing 5 is done');
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
        Schema::dropIfExists('projects');
    }
}
