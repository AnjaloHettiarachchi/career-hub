<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->unsignedInteger('stu_id');
            $table->unsignedInteger('com_id');
            $table->string('con_doc_id', 10);
            $table->timestamps();

            $table->foreign('stu_id')->references('stu_id')->on('students');
            $table->foreign('com_id')->references('com_id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations');
    }
}
