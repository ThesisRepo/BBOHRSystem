<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverridenRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overriden_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('overriden_requestable_id');
            $table->string('overriden_requestable_type');
            $table->unsignedBigInteger('roles_id');
            $table->timestamps();
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overriden_requests');
    }
}
