<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_reservations', function (Blueprint $table) {
            $table->id();
            $table->text('requestors')->nullable(); // ✅ Changed from json to text
            $table->string('l_name'); // First requestor (for display)
            $table->string('f_name');
            $table->string('m_name')->nullable();
            $table->unsignedBigInteger('id_division_unit')->nullable();
            $table->unsignedBigInteger('id_position')->nullable();
            $table->string('destination');
            $table->date('departure_date');
            $table->time('departure_time')->nullable();
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->string('vehicle_name');
            $table->string('plate_number');
            $table->string('driver_name');
            $table->text('purpose');
            $table->string('attachment')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Declined'])->default('Pending');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_position')->references('id')->on('position')->onDelete('set null');
            $table->foreign('id_division_unit')->references('id')->on('division_unit')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_reservations');
    }
};
