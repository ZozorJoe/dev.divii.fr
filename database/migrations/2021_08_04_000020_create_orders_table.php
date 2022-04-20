<?php

use App\Models\Shop\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique()->nullable();
            $table->string('status', 50)->default(Order::STATUS_PING);
            $table->float('sub_total', 20, 4)->nullable();
            $table->float('vat_total', 20, 4)->nullable();
            $table->float('total', 20, 4)->nullable();
            $table->string('currency', 3)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
