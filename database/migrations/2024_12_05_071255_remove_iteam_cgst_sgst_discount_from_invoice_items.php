<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIteamCgstSgstDiscountFromInvoiceItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn(['iteam_cgst', 'iteam_sgst', 'iteam_discount']);
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
            $table->decimal('iteam_cgst', 8, 2)->nullable();
            $table->decimal('iteam_sgst', 8, 2)->nullable();
            $table->decimal('iteam_discount', 8, 2)->nullable();
        });
    }
}
