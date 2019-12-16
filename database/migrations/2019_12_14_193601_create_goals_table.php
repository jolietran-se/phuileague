<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('match_id')->nullable();    // id trận đấu
            $table->integer('player_id')->nullable();   // cầu thủ ghi bàn
            $table->integer('goal_time')->nullable();   // ghi bàn ở phút thứ bao nhiêu
            $table->integer('isowngoal')->nullable();   // có phải phải lưới nhà hay không
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
        Schema::dropIfExists('goals');
    }
}
