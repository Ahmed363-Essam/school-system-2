<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            $table->unsignedBigInteger('from_grade');
            $table->foreign('from_grade')->references('id')->on('grades')->onDelete('cascade');

            $table->unsignedBigInteger('from_Classroom');
            $table->foreign('from_Classroom')->references('id')->on('classrooms')->onDelete('cascade');

            $table->unsignedBigInteger('from_section');
            $table->foreign('from_section')->references('id')->on('sectoins')->onDelete('cascade');

            $table->unsignedBigInteger('to_grade');
            $table->foreign('to_grade')->references('id')->on('grades')->onDelete('cascade');

            $table->unsignedBigInteger('to_Classroom');
            $table->foreign('to_Classroom')->references('id')->on('classrooms')->onDelete('cascade');

            $table->unsignedBigInteger('to_section');
            $table->foreign('to_section')->references('id')->on('sectoins')->onDelete('cascade');

            $table->string('academic_year');
            $table->string('academic_year_new');
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
        Schema::dropIfExists('promotions');
    }
}
