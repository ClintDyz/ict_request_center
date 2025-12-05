<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignatureAndValidUntilToIdRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('id_request', function (Blueprint $table) {
             $table->string('signature')->nullable()->after('image');
            $table->date('valid_until')->nullable()->after('signature');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('id_request', function (Blueprint $table) {
           $table->dropColumn(['signature', 'valid_until']);

        });
    }
}
