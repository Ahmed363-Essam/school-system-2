<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');

            //Fatherinformation
            $table->string('Name_Father');
            $table->string('National_ID_Father');
            $table->string('Passport_ID_Father');
            $table->string('Phone_Father');
            $table->string('Job_Father');
            $table->unsignedBigInteger('Nationality_Father_id')->references('id')->on('nationalities')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('Blood_Type_Father_id')->references('id')->on('type__bloods')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('Religion_Father_id')->references('id')->on('religions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('Address_Father');

            //Mother information
            $table->string('Name_Mother');
            $table->string('National_ID_Mother');
            $table->string('Passport_ID_Mother');
            $table->string('Phone_Mother');
            $table->string('Job_Mother');
            $table->unsignedBigInteger('Nationality_Mother_id')->references('id')->on('nationalities')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('Blood_Type_Mother_id')->references('id')->on('type__bloods')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('Religion_Mother_id')->references('id')->on('religions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('Address_Mother');
            $table->timestamps();

            /*

            $table->foreign('Nationality_Father_id')->references('id')->on('nationalities');
            $table->foreign('Blood_Type_Father_id')->references('id')->on('type__bloods');
            $table->foreign('Religion_Father_id')->references('id')->on('religions');
            $table->foreign('Nationality_Mother_id')->references('id')->on('nationalities');
            $table->foreign('Blood_Type_Mother_id')->references('id')->on('type__bloods');
            $table->foreign('Religion_Mother_id')->references('id')->on('religions');

            */

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parents');
    }
}
