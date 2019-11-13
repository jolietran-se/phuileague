<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->string('avatar');
            $table->integer('club_id')->usigned();
            $table->string('indentification');
            $table->string('phone');
            $table->date('birthday')->nullable();
            $table->string('country')->nullable();
            $table->integer('uniform_number');
            $table->string('uniform_name');
            $table->integer('position_id')->usigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
