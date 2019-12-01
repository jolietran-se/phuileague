<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('owner_id')->usigned();
            $table->string('name')->unique();
            $table->string('logo')->nullable();
            $table->string('uniform')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('numer_player')->nullable();
            $table->boolean('gender');
            $table->string('ages');
            $table->integer('club_type')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('clubs');
    }
}
