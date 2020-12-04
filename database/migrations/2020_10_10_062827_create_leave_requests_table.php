<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('leave_type_id');
            $table->UnsignedBigInteger('department_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->double('number_of_days');
            $table->UnsignedBigInteger('approver_role_id');
            $table->UnsignedBigInteger('status_id')->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
            $table->foreign('approver_role_id')->references('id')->on('roles')->onDelete('cascade'); 
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');           
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
        Schema::dropIfExists('leave_requests');
    }
}
