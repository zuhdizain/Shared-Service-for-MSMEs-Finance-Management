<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('division_id');
            $table->string('employee_name');
            $table->string('employee_email');
            $table->string('employee_position');
            $table->string('training_name');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('training_institute');
            $table->bigInteger('training_phone');
            $table->string('training_email')->nullable();
            $table->double('training_fee');
            $table->string('training_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainings');
    }
}
