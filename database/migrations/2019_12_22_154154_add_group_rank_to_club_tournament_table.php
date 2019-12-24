<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupRankToClubTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('club_tournament', function (Blueprint $table) {
            $table->integer('g_rank')->nullable();
            $table->integer('k_rank')->nullable();
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
            $table->dropColumn('g_rank');
            $table->dropColumn('k_rank');
        });
    }
}
