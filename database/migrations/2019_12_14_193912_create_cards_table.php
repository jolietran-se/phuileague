<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('match_id')->nullable();    // id trận đấu
            $table->integer('player_id')->nullable();   // cầu thủ bị thẻ phạt
            $table->integer('goal_time')->nullable();   // thẻ đỏ ở phút thứ bao nhiêu
            $table->integer('isredcard')->nullable();   // có phải thẻ đỏ không
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
        Schema::dropIfExists('cards');
    }
}
