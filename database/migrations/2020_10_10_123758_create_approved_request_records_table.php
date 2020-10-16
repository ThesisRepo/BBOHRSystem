<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovedRequestRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approved_request_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->UnsignedBigInteger('approver_id');
            $table->UnsignedBigInteger('recordable_id');
            $table->string('recordable_type');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approved_request_records');
    }
}
