<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitLossesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profit_losses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cogs_id');
            $table->unsignedBigInteger('sse_id');
            $table->unsignedBigInteger('gac_id');
            $table->smallInteger('month');
            $table->double('total_sales');
            $table->double('total_hpp');
            $table->double('total_sse');
            $table->double('total_gac');
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
        Schema::dropIfExists('profit_losses');
    }
}
