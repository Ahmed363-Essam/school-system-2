<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectoins', function (Blueprint $table) {
            $table->id();
            $table->string('Name_Section');
            $table->integer('Status');
            $table->unsignedBigInteger('Grade_id');
            $table->unsignedBigInteger('Class_id');
            $table->foreign('Grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Class_id')->references('id')->on('classrooms')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('sectoins');
    }
}
