<?php

use App\Models\Shop\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->morphs('orderable');
            $table->unsignedInteger('quantity')->default(0);
            $table->float('price', 20, 4)->nullable();
            $table->float('sub_total', 20, 4)->nullable();
            $table->float('vat', 8, 4)->nullable();
            $table->float('vat_total', 20, 4)->nullable();
            $table->float('row_total', 20, 4)->nullable();
            $table->string('currency', 3)->nullable();
            $table->unsignedBigInteger('order_id');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
