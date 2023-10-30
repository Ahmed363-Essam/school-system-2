<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_section', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('teacher_id')->unsigned();

            $table->bigInteger('sectoins_id')->unsigned();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');

            $table->foreign('sectoins_id')->references('id')->on('sectoins')->onDelete('cascade');



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
        Schema::dropIfExists('teacher_section');
    }
}
