<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDegreeProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('degree_programs', function (Blueprint $table) {
            $table->increments('deg_id');
            $table->string('deg_title');
            $table->unsignedInteger('fac_id');
            $table->unsignedInteger('uni_id');
            $table->timestamps();

            //Keys
            $table->foreign('fac_id')->references('fac_id')->on('faculties');
            $table->foreign('uni_id')->references('uni_id')->on('universities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('degree_programs');
    }
}
