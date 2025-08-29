<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRsPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rs_id')->constrained('rstbl');
            $table->string('p_title');
            $table->string('p_nature');
            $table->date('p_date');
            $table->date('p_venue');
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
        Schema::dropIfExists('rs_publications');
    }
}
