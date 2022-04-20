<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBirthToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('birth_hour')->after('birthday')->nullable()->index();
            $table->string('birth_place')->after('birth_hour')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['birth_hour']);
            $table->dropColumn('birth_hour');

            $table->dropIndex(['birth_place']);
            $table->dropColumn('birth_place');
        });
    }
}
