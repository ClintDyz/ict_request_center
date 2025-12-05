<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowerItemsTable extends Migration
{
    public function up()
    {
        Schema::create('borrower_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('borrower_request_id');
            $table->unsignedBigInteger('id_item_description');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('borrower_request_id')
                  ->references('id')
                  ->on('borrower_request')
                  ->onDelete('cascade');

            $table->foreign('id_item_description')
                  ->references('id')
                  ->on('ict_equipment')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrower_items');
    }
}
