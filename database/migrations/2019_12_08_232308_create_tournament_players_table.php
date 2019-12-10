<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('club_tournament_id');
            $table->integer('player_id');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->integer('uniform_number');
            $table->string('uniform_name')->nullable();
            $table->integer('position')->usigned();
            $table->integer('role')->usigned();
            $table->string('front_idcard')->nullable();
            $table->string('backside_idcard')->nullable();
            $table->string('phone')->nullable();
            $table->string('birthday')->nullable();
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
        Schema::dropIfExists('tournament_players');
    }
}
