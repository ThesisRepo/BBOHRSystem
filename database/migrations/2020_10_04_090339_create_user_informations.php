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
            $table->string('company_number')->nullable();
            $table->string('profile_url', 80);  
            $table->string('company_position')->nullable();
            $table->date('date_hired')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('company_status')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();  
            $table->string('tin_number')->nullable();
            $table->string('sss_number')->nullable();
            $table->string('pag_ibig_number')->nullable();
            $table->string('philhealth_number')->nullable();
            $table->integer('allowed_leave_number')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
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
