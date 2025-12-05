<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToBorrowerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::table('borrower_items', function (Blueprint $table) {
        $table->enum('status', ['borrowed', 'returned'])->default('borrowed')->after('quantity');
        $table->date('actual_return_date')->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('borrower_items', function (Blueprint $table) {
        $table->dropColumn(['status', 'actual_return_date']);
    });
}
}
