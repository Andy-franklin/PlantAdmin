<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_positions', function (Blueprint $table) {
            $table->id();

            $table->string('position');

            $table->foreignId('location_id')->constrained('locations');
            $table->foreignId('plant_id')->constrained('plants');

            $table->timestamps();
        });

        Schema::table('environments', function (Blueprint $table) {
            $table->foreignId('location_position_id')->constrained('location_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_positions');
    }
}
