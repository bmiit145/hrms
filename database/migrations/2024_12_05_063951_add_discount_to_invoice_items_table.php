<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('iteam_discount')->nullable()->after('price'); 
            $table->string('iteam_sgst')->nullable()->after('iteam_discount'); 
            $table->string('iteam_cgst')->nullable()->after('iteam_sgst'); 
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
            $table->dropColumn('iteam_discount');
            $table->dropColumn('iteam_sgst');
            $table->dropColumn('iteam_cgst');
        });
    }
}
