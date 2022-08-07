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
        Schema::create('detail_pertandingans', function (Blueprint $table) {
            $table->id();
            $table->time('waktu')->comment('waktu pemain mencetak goal');
            $table->unsignedBigInteger('pemain_id')->comment('pemain yang mencetak goal');
            $table->unsignedBigInteger('pertandingan_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pemain_id')->references('id')->on('pemains');
            $table->foreign('pertandingan_id')->references('id')->on('pertandingans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pertandingans');
    }
};
