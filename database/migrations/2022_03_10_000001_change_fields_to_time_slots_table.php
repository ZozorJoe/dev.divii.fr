<?php

use App\Models\Chat\TimeSlot;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsToTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_slots', function (Blueprint $table) {
            $table->dropColumn('model_type');
            $table->renameColumn('model_id', 'user_id');
        });

        Schema::table('time_slots', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change()->nullable();
        });

        TimeSlot::whereDoesntHave('user')->delete();

        Schema::table('time_slots', function (Blueprint $table) {
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
        Schema::table('time_slots', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->renameColumn('user_id', 'model_id');
            $table->string('model_type')->nullable();
        });
    }
}
