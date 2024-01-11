<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ci_id');
            $table->unsignedBigInteger('cogs_id');
            $table->unsignedBigInteger('sse_id');
            $table->unsignedBigInteger('gac_id');
            $table->smallInteger('month');
            $table->double('sales');
            $table->double('total_cogs');
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
        Schema::dropIfExists('cash_flows');
    }
}
