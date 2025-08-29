<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccreditationAveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accreditation_averages', function (Blueprint $table) {
                    $table->id();
            $table->unsignedBigInteger('rstbl_id'); // Add reference to resource speaker
            $table->string('field_of_expertise')->nullable();
            $table->decimal('avg_education', 8, 2)->default(0);
            $table->decimal('avg_work', 8, 2)->default(0);
            $table->decimal('avg_seminar', 8, 2)->default(0);
            $table->decimal('avg_experience', 8, 2)->default(0);
            $table->decimal('avg_award', 8, 2)->default(0);
            $table->decimal('avg_total', 8, 2)->default(0);
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
        Schema::dropIfExists('accreditation_averages');
    }
}
