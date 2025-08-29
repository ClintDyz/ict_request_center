<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccreditationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rstbl_id'); // Foreign key to speakers table
            $table->string('field_of_expertise')->nullable();
            $table->string('training_title_rs')->nullable();
            $table->string('education')->nullable();
            $table->string('work')->nullable();
            $table->string('seminar')->nullable();
            $table->string('experience')->nullable();
            $table->string('award')->nullable();
            $table->string('total')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            // Foreign key constraint (optional but recommended)
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
        Schema::dropIfExists('accreditations');
    }
}
