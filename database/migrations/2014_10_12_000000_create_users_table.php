<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('branch_office_id')->unsigned()->default(1);
            $table->foreign('branch_office_id')->references('id')->on('branch_offices')->onDelete('cascade');
            $table->string('status_patient')->nullable(); 
            $table->string('phone');
            $table->boolean('status')->default(true);
            $table->boolean('active')->default(true);
            $table->integer('absences')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
