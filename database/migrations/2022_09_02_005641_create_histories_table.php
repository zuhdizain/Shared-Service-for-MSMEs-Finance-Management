<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('division_id');
            $table->string('name');
            $table->string('email');
            $table->string('position');
            $table->bigInteger('phone');
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->string('religion');
            $table->integer('age');
            $table->enum('marriage', ['Menikah', 'Belum Menikah']);
            $table->integer('child');
            $table->enum('status', ['Karyawan Tetap', 'Magang', 'Keluar']);
            $table->date('acceptanceDate');
            $table->date('outDate');
            $table->string('hospitalChart');
            $table->string('address');
            $table->string('statement');
            $table->integer('severancePay')->nullable();
            $table->string('statementLetter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
