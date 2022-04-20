<?php

use App\Models\Zodiac\Horoscope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateHoroscopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horoscopes', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(Horoscope::STATUS_DRAFT)->index();
            $zodiacs = [
                'Bélier', 'Taureau', 'Gémeaux',
                'Cancer', 'Lion', 'Vierge',
                'Balance', 'Scorpion', 'Sagittaire',
                'Capricorne', 'Verseau', 'Poissons',
            ];
            foreach ($zodiacs as $zodiac){
                $table->text(Str::slug($zodiac))->nullable();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horoscopes');
    }
}
