<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreferredEnvironmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferred_environments', function (Blueprint $table) {
            $table->id();

            $table->float('temperature')->nullable();
            $table->float('moisture')->nullable();
            $table->float('humidity')->nullable();
            $table->float('light')->nullable();

            $table->foreignId('variety_id')->nullable()->constrained('varieties');
            $table->foreignId('species_id')->nullable()->constrained('species');

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
        Schema::dropIfExists('preferred_environments');
    }
}
