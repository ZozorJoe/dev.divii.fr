<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->morphs('invoiceable');
            $table->unsignedInteger('quantity')->default(0);
            $table->float('price', 20, 4)->nullable();
            $table->float('sub_total', 20, 4)->nullable();
            $table->float('vat', 8, 4)->nullable();
            $table->float('vat_total', 20, 4)->nullable();
            $table->float('row_total', 20, 4)->nullable();
            $table->string('currency', 3)->nullable();
            $table->unsignedBigInteger('order_item_id')->nullable();
            $table->unsignedBigInteger('invoice_id');
            $table->timestamps();

            $table->foreign('order_item_id')->references('id')->on('order_items')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('invoice_id')->references('id')->on('invoices')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
