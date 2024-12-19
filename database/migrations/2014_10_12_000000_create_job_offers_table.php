<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->timestamp('createdAt')->useCurrent(); 
            $table->timestamp('updatedAt')->useCurrent()->useCurrentOnUpdate();
            $table->string('Company')->nullable();
            $table->unsignedBigInteger('idCompany')->nullable(); // Mantener como unsignedBigInteger
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('idApplyStatus')->default(1);
            $table->integer('idRanking')->nullable(); // Cambiado a integer
            $table->unsignedTinyInteger('idMyChance')->nullable();
            $table->unsignedTinyInteger('idPleasantness')->nullable();
            $table->unsignedTinyInteger('idPriority')->nullable();
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
        Schema::dropIfExists('job_offers');
    }
}
