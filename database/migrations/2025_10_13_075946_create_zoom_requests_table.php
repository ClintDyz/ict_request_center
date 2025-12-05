<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('zoom_request', function (Blueprint $table) {
        $table->id();
        $table->string('f_name',100);
        $table->string('l_name',100);
        $table->string('m_name',100)->nullable();
        $table->date('start_date')->nullable();
        $table->time('start_time')->nullable();
        $table->date('end_date')->nullable();
        $table->time('end_time')->nullable();
        $table->string('topic',100);
        $table->integer('no_of_participants')->nullable();
        $table->unsignedBigInteger('id_position')->nullable();
        $table->unsignedBigInteger('id_division_unit')->nullable();
        $table->string('month',20)->nullable();
        $table->integer('year')->nullable();
        $table->timestamps();
    });

    // ✅ Add foreign keys AFTER table creation
    Schema::table('zoom_request', function (Blueprint $table) {
        $table->foreign('id_position')->references('id')->on('position')->onDelete('set null');
        $table->foreign('id_division_unit')->references('id')->on('division_unit')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zoom_requests');
    }
}
