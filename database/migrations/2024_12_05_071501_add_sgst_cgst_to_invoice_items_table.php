<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSgstCgstToInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('discount_persentage')->nullable()->after('client_id'); 
            $table->string('sgst_persentage')->nullable()->after('discount_persentage'); 
            $table->string('cgst_persentage')->nullable()->after('sgst_persentage'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('discount_persentage');
            $table->dropColumn('sgst_persentage');
            $table->dropColumn('cgst_persentage');
        });
    }
}
