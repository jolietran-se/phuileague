<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRowToClubTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('club_tournament', function (Blueprint $table) {
            $table->integer('g_number_win')->nullable();
            $table->integer('g_number_draw')->nullable();
            $table->integer('g_number_lost')->nullable();
            $table->integer('g_point')->nullable();
            $table->integer('g_number_yellow')->nullable();
            $table->integer('g_number_red')->nullable();
            $table->integer('g_goal_for')->nullable();
            $table->integer('g_goal_against')->nullable();
            $table->integer('isnext')->nullable();
            $table->integer('k_number_win')->nullable();
            $table->integer('k_number_draw')->nullable();
            $table->integer('k_number_lost')->nullable();
            $table->integer('k_point')->nullable();
            $table->integer('k_number_yellow')->nullable();
            $table->integer('k_number_red')->nullable();
            $table->integer('k_goal_for')->nullable();
            $table->integer('k_goal_against')->nullable();
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
            $table->dropColumn('g_number_win');
            $table->dropColumn('g_number_draw');
            $table->dropColumn('g_number_lost');
            $table->dropColumn('g_point');
            $table->dropColumn('g_number_yellow');
            $table->dropColumn('g_number_red');
            $table->dropColumn('g_goal_for');
            $table->dropColumn('g_goal_against');
            $table->dropColumn('isnext');
            $table->dropColumn('k_number_win');
            $table->dropColumn('k_number_draw');
            $table->dropColumn('k_number_lost');
            $table->dropColumn('k_point');
            $table->dropColumn('k_number_yellow');
            $table->dropColumn('k_number_red');
            $table->dropColumn('k_goal_for');
            $table->dropColumn('k_goal_against');
        });
    }
}
