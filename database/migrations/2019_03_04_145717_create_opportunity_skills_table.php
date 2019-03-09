<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpportunitySkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_skills', function (Blueprint $table) {
            $table->unsignedInteger('op_id');
            $table->unsignedInteger('skill_id');
            $table->integer('op_skill_level');
            $table->timestamps();

            $table->foreign('op_id')->references('op_id')->on('opportunities');
            $table->foreign('skill_id')->references('skill_id')->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opportunity_skills');
    }
}
