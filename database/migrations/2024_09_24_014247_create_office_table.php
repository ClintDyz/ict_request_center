<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rs_id')->constrained('rstbl');
            $table->string('office_organization');
            $table->string('position');
            $table->string('address');
            $table->string('building_no');
            $table->string('barangay')->nullable();
            $table->string('municipality');
            $table->string('province');
            $table->string('zip_code');
            $table->string('tel_no')->nullable();
            $table->string('cell_no')->nullable();
            $table->string('fax_no')->nullable();
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
        Schema::dropIfExists('office');
    }
}
