<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamHeadColumnsToLeaveManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_managements', function (Blueprint $table) {
            $table->string('team_head_status')->nullable()->after('status')->comment('0 = Rejected, 1 = Approved')->after('rejected_reason');
            $table->string('team_head_rejected_reasons')->nullable()->after('team_head_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_managements', function (Blueprint $table) {
            $table->dropColumn('team_head_status');
            $table->dropColumn('team_head_rejected_reasons');
        });
    }
}
