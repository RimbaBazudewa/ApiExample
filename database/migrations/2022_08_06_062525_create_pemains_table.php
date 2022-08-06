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
        Schema::create('pemains', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->float('tinggi_badan');
            $table->float('berat_badan');
            $table->enum('posisi', ["penyerang", "gelandang", "bertahan", "penjaga gawang"])->comment("posisi pemain");
            $table->integer("no_punggung")->unique();
            $table->unsignedBigInteger("tim_id");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tim_id')->references('id')->on('tims');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemains');
    }
};
