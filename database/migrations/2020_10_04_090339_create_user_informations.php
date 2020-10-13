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
            $table->unsignedBigInteger('department_id');
            $table->string('company_number');
            $table->string('profile_url')->nullable();  
            $table->string('company_position');
            $table->date('date_hired');
            $table->string('contact_number');
            $table->string('civil_status');
            $table->string('company_status');
            $table->date('birthday');
            $table->string('address');  
            $table->string('tin_number');
            $table->string('sss_number');
            $table->string('pag_ibig_number');
            $table->string('philhealth_number');
            $table->integer('allowed_leave_number');
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
