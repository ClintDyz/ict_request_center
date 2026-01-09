<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRsLettersTable extends Migration
{
    public function up()
    {
        Schema::create('rs_letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rstbl_id'); // link to speaker
            $table->string('rs_letter')->nullable(); // URL link
            $table->timestamps();

            $table->foreign('rstbl_id')->references('id')->on('rstbls')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rs_letters');
    }
}
