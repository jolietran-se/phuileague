<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTowRowToClubTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('club_tournament', function (Blueprint $table) {
            $table->integer('g_number_match')->nullable();
            $table->integer('k_number_match')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('club_tournament', function (Blueprint $table) {
            $table->dropColumn('g_number_match');
            $table->dropColumn('k_number_match');
        });
    }
}
