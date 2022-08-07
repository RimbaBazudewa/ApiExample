<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertandingans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->comment('tanggal pertandingan');
            $table->time('waktu')->comment('waktu_pertandingan');
            $table->unsignedBigInteger('home_tim_id')->comment('tim tuan rumah');
            $table->unsignedBigInteger('away_tim_id')->comment('tim sebagai tamu');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('home_tim_id')->references('id')->on('tims');
            $table->foreign('away_tim_id')->references('id')->on('tims');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pertandingans');
    }
};
