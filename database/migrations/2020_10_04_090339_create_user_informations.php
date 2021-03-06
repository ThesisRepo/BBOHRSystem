<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInformations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('shift_time_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('company_number')->nullable();
            $table->string('profile_url', 80)->nullable();
            $table->date('date_hired')->nullable();
            $table->string('contact_number')->nullable();
            $table->unsignedBigInteger('civil_status_id')->nullable();
            $table->unsignedBigInteger('company_status_id')->nullable();
            $table->date('regularization_date')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();  
            $table->string('tin_number')->nullable();
            $table->string('sss_number')->nullable();
            $table->string('pag_ibig_number')->nullable();
            $table->string('philhealth_number')->nullable();
            $table->integer('allowed_leave_number')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('shift_time_id')->references('id')->on('shift_times')->onDelete('cascade');
            $table->foreign('civil_status_id')->references('id')->on('civil_status')->onDelete('cascade');           
            $table->foreign('company_status_id')->references('id')->on('company_status')->onDelete('cascade');                       
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
        Schema::dropIfExists('user_informations');
    }
}
