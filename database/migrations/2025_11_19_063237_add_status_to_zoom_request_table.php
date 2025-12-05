<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToZoomRequestTable extends Migration
{
    public function up()
    {
        // Column already added manually via SQL
        // This migration is just for record keeping
    }

    public function down()
    {
        Schema::table('zoom_request', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
