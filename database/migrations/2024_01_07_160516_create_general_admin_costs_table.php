<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralAdminCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_admin_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->smallInteger('month');
            $table->double('salaries_and_allowances');
            $table->double('electricity_and_water');
            $table->double('transportation');
            $table->double('communication');
            $table->double('office_stationery');
            $table->double('consultant');
            $table->double('cleanliness_and_security');
            $table->double('maintenance_and_renovation');
            $table->double('depreciation');
            $table->double('tax');
            $table->double('other_cost');
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
        Schema::dropIfExists('general_admin_costs');
    }
}
