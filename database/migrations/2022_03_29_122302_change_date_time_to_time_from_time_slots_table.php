<?php

use App\Models\Chat\TimeSlot;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateTimeToTimeFromTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_slots', function (Blueprint $table) {
            $table->integer('weekday')->after('repetition')->index()->nullable();
        });

        $timeSlots = TimeSlot::all();
        foreach ($timeSlots as $timeSlot){
            $timeSlot->weekday = Carbon::createFromFormat('Y-m-d H:i:s', $timeSlot->start_at)->weekday();
            $timeSlot->save();
        }

        Schema::table('time_slots', function (Blueprint $table) {
            $table->time('start_at')->nullable()->index()->change();
            $table->time('end_at')->nullable()->index()->change();
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
            $table->dropIndex('time_slots_start_at_index');
            $table->dropIndex('time_slots_end_at_index');

            $table->dateTime('start_at')->change();
            $table->dateTime('end_at')->change();
            $table->dropColumn('weekday');
        });
    }
}
