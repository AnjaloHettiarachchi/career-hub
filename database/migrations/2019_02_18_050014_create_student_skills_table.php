<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_skills', function (Blueprint $table) {
            $table->unsignedInteger('stu_id');
            $table->unsignedInteger('skill_id');
            $table->integer('skill_level');
            $table->timestamps();

            //Keys
            $table->foreign('stu_id')->references('stu_id')->on('students');
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
        Schema::dropIfExists('student_skills');
    }
}
