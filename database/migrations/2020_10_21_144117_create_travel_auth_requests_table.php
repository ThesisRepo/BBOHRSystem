<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelAuthRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_auth_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->string('destination');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('details');
            $table->string('emergency_contact');
            $table->UnsignedBigInteger('employee_to_cover_id');
            $table->string('file_uri');
            $table->UnsignedBigInteger('approver_role_id');
            $table->UnsignedBigInteger('status_id')->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employee_to_cover_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_role_id')->references('id')->on('roles')->onDelete('cascade');            
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_auth_requests');
    }
}
