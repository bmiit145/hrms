<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIteamToInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn('qty_or_hourse');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('iteam_hours')->nullable()->after('project_type'); 
            $table->string('iteam_qty')->nullable()->after('iteam_hours'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn('iteam_hours');
            $table->dropColumn('iteam_qty');
        });
    }
}
