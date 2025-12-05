<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('id_request', function (Blueprint $table) {
        $table->id();
        $table->string('f_name',191);
        $table->string('l_name',191);
        $table->string('m_name',191)->nullable();
        $table->string('nick_name',191)->nullable();
        $table->unsignedBigInteger('id_position')->nullable();
        $table->unsignedBigInteger('id_division_unit')->nullable();
        $table->date('birthdate')->nullable();
        $table->string('blood_type',10)->nullable();
        $table->string('status',101)->nullable();
        $table->string('image')->nullable();
        $table->string('emergency_contact_name',255)->nullable();
        $table->text('emergency_contact_address')->nullable();
        $table->string('emergency_contact_number',50)->nullable();
        $table->timestamps();

          });
    // ✅ Add foreign keys AFTER table creation
    Schema::table('id_request', function (Blueprint $table) {
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
        Schema::dropIfExists('id_requests');
    }
}
