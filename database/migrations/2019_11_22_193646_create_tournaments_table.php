<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            // Tạo giải ban đầu
            
            $table->bigIncrements('id');
            $table->integer('owner_id')->usigned();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->boolean('gender')->nullable();
            $table->string('stadium')->nullable();
            $table->string('address')->nullable();

            $table->integer('tournament_type_id')->usigned();
            $table->integer('number_club')->nullable();
            $table->integer('number_player')->nullable();
            $table->integer('number_group')->nullable();
            $table->integer('number_knockout')->nullable();
            $table->integer('number_round')->nullable();

            $table->integer('score_win')->nullable();
            $table->integer('score_draw')->nullable();
            $table->integer('score_lose')->nullable();

            $table->string('register_permission')->nullable();
            $table->string('register_date')->nullable();
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
        Schema::dropIfExists('tournaments');
    }
}
