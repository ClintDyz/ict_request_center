<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowerRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

Schema::create('borrower_request', function (Blueprint $table) {
            $table->id();
            $table->string('f_name',100);
            $table->string('l_name',100);
            $table->string('m_name',100)->nullable();
            $table->unsignedBigInteger('id_position')->nullable();
            $table->unsignedBigInteger('id_division_unit')->nullable();
            $table->unsignedBigInteger('id_item_description')->nullable();
            $table->integer('quantity')->nullable();
            $table->date('date_borrowed')->nullable();
            $table->date('date_return')->nullable();
            $table->timestamps();
        });
        Schema::table('borrower_request', function (Blueprint $table) {
            $table->foreign('id_position')->references('id')->on('position')->onDelete('set null');
            $table->foreign('id_Division_Unit')->references('id')->on('division_unit')->onDelete('set null');
            $table->foreign('id_item_description')->references('id')->on('ict_equipment')->onDelete('set null');
        });
    }

    public function down()
    {
        // 🎯 Paste your table drop code here
        Schema::dropIfExists('borrower_request');
    }
}
