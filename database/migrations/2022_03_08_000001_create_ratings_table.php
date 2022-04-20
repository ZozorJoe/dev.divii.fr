<?php

use App\Models\User\Rating;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(Rating::STATUS_PING)->nullable()->index();
            $table->text('comment')->nullable();
            $table->decimal('value', 2, 1);
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('expert_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('expert_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('ratings');
    }
}
