<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->unique();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('gender')->nullable();
            $table->unsignedBigInteger('id_position')->nullable();
            $table->unsignedBigInteger('id_division_unit')->nullable();
            $table->string('emp_type')->nullable();
            $table->string('roles')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
