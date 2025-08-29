<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rstbl', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('given_name');
            $table->string('middle_name')->nullable();
            $table->string('ext_name')->nullable();
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->integer('age');
            $table->string('email')->unique();
            $table->string('expertise')->nullable();
            $table->string('building_no')->nullable();
            $table->string('home_address')->nullable();
            $table->string('home_building_no')->nullable();
            $table->string('home_barangay')->nullable();
            $table->string('home_municipality');
            $table->string('home_province');
            $table->string('home_zip_code');
            $table->string('home_tel_no')->nullable();
            $table->string('home_cell_no')->nullable();
            $table->string('home_fax_no')->nullable();
            $table->string('created_by');
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
        Schema::dropIfExists('rstbl');
    }
}
