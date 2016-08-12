<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectUserCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_user_course', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_course_id');
            $table->integer('subject_id');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->tinyInteger('status');
            $table->string('progress');
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
        Schema::drop('subject_user_course');
    }
}
