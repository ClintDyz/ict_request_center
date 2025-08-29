<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRsExperienceTrainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_experience_trainer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rs_id')->constrained('rstbl');
            $table->string('rst_title');
            $table->string('rst_venue');
            $table->date('rst_date');
            $table->integer('rst_no_hours');
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
        Schema::dropIfExists('rs_experience_trainer');
    }
}
