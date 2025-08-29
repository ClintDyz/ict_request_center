<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestResourceSpeakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_resource_speakers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rstbl_id');
            $table->string('gender')->nullable();
            $table->string('agency')->nullable();
            $table->string('division')->nullable();
            $table->string('training_directory')->nullable();
            $table->string('training_title')->nullable();
            $table->string('venue')->nullable();
            $table->date('date')->nullable();
            $table->integer('no_hours')->nullable();
            $table->integer('no_participants')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            // Optional foreign key constraint
            $table->foreign('rstbl_id')->references('id')->on('rstbl')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_resource_speakers');
    }
}
