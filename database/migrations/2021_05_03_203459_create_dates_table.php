<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->unsigned()->default(1);
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('doctor_id')->unsigned()->default(1);
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('shift_id')->unsigned()->default(1);
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            $table->unsignedBigInteger('dates_infos_id')->unsigned()->default(1);
            $table->foreign('dates_infos_id')->references('id')->on('dates_infos')->onDelete('cascade');
            $table->date('date');
            $table->string('service');
            $table->boolean('payed');
            $table->string('estado');
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
        Schema::dropIfExists('dates');
    }
}
