<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('stu_id');
            $table->binary('stu_avatar')->nullable();
            $table->string('stu_prov_id');
            $table->string('stu_full_name');
            $table->text('stu_bio');
            $table->string('stu_con_num');
            $table->string('stu_email');
            $table->unsignedInteger('deg_id');
            $table->unsignedInteger('stu_user_id');
            $table->unsignedInteger('sit_id');
            $table->timestamps();

            //Keys
            $table->foreign('stu_user_id')->references('stu_user_id')->on('student_users');
            $table->foreign('deg_id')->references('deg_id')->on('degree_programs');
            $table->foreign('sit_id')->references('sit_id')->on('student_id_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
