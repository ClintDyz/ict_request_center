<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRsTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_training', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rs_id')->constrained('rstbl');
            $table->string('rt_title');
            $table->string('rt_venue');
            $table->date('rt_date');
            $table->integer('rt_no_hours');
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
        Schema::dropIfExists('rs_training');
    }
}
