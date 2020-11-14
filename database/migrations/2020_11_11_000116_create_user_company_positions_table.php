<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCompanyPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_company_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_information_id');
            $table->UnsignedBigInteger('company_position_id');
            $table->timestamps();
            $table->foreign('user_information_id')->references('id')->on('user_informations')->onDelete('cascade');
            $table->foreign('company_position_id')->references('id')->on('company_positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_company_positions');
    }
}
