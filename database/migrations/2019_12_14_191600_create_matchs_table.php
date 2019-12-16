<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tournament_id');
            $table->string('stage')->nullable();           // vòng đấu
            $table->integer('round')->nullable();          // lượt thi đấu vòng bảng
            $table->date('date')->nullable();              // ngày thi đấu
            $table->time('time')->nullable();              // giờ thi đấu
            $table->string('address')->nullable();         // địa điểm thi đấu
            $table->integer('clubA_id')->nullable();       // đội A
            $table->integer('clubB_id')->nullable();       // đội B
            $table->integer('goalA')->nullable();          // số bàn thắng đội A
            $table->integer('goalB')->nullable();          // số bàn thắng đội B
            $table->integer('yellow_card_A')->nullable();  // số thẻ vàng đội A
            $table->integer('yellow_card_B')->nullable();  // số thẻ vàng đội B
            $table->integer('red_card_A')->nullable();     // số thẻ đỏ đội A
            $table->integer('red_card_B')->nullable();     // số thẻ đỏ đội B
            $table->string('status')->nullable();          // trạng thái trận đấu
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
        Schema::dropIfExists('matchs');
    }
}
