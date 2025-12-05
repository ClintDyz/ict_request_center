<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveItemFieldsFromBorrowerRequest extends Migration
{
    public function up()
    {
        Schema::table('borrower_request', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['id_item_description']);

            // Drop columns
            $table->dropColumn(['id_item_description', 'quantity']);
        });
    }

    public function down()
    {
        Schema::table('borrower_request', function (Blueprint $table) {
            $table->unsignedBigInteger('id_item_description')->nullable();
            $table->integer('quantity')->nullable();

            $table->foreign('id_item_description')
                  ->references('id')
                  ->on('ict_equipment')
                  ->onDelete('set null');
        });
    }
}
