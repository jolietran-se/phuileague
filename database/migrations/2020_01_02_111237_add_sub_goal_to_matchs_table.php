<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubGoalToMatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matchs', function (Blueprint $table) {
            $table->integer('sub_goal_A')->nullable();
            $table->integer('sub_goal_B')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matchs', function (Blueprint $table) {
            $table->dropColumn('sub_goal_A');
            $table->dropColumn('sub_goal_B');
        });
    }
}
