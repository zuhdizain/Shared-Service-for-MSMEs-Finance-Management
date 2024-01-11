<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id');
            $table->foreignId('user_id');
            $table->string('employee_name');
            $table->string('employee_email');
            $table->string('employee_position');
            $table->bigInteger('employee_phone');
            $table->enum('employee_gender', ['Pria', 'Wanita']);
            $table->string('employee_religion');
            $table->integer('employee_age');
            $table->enum('employee_marriage', ['Menikah', 'Belum Menikah']);
            $table->integer('employee_child');
            $table->enum('employee_status', ['Karyawan Tetap', 'Magang', 'Resign']);
            $table->date('employee_acceptanceDate');
            $table->string('last_education');
            $table->string('employee_hospitalChart');
            $table->string('employee_address');
            $table->string('employee_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
