<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid');
            $table->text('qr_image')->nullable();

            $table->string('name');
            $table->foreignId('status_id')->constrained('statuses');

            $table->integer('filial_generation')->default(0);

            $table->foreignId('father_parent')->nullable()->constrained('plants', 'id');
            $table->foreignId('mother_parent')->nullable()->constrained('plants', 'id');
            $table->foreignId('variety_id')->nullable()->constrained('varieties');

            $table->integer('pot_size')->nullable();

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
        Schema::dropIfExists('plants');
    }
}
