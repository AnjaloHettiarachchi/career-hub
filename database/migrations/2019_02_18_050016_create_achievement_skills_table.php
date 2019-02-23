<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievement_skills', function (Blueprint $table) {
            $table->unsignedInteger('ach_id');
            $table->unsignedInteger('skill_id');
            $table->timestamps();

            //Keys
            $table->foreign('ach_id')->references('ach_id')->on('achievements');
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
        Schema::dropIfExists('achievement_skills');
    }
}
