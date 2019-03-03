<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('com_id');
            $table->binary('com_avatar');
            $table->string('com_title');
            $table->text('com_desc');
            $table->string('com_address');
            $table->unsignedInteger('aoe_id');
            $table->unsignedInteger('com_user_id');
            $table->timestamps();

            //Keys
            $table->foreign('aoe_id')->references('aoe_id')->on('areas_of_expertise');
            $table->foreign('com_user_id')->references('com_user_id')->on('company_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
