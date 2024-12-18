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
            $table->string('idCompany')->nullable();
            $table->string('status')->default('1');
            $table->string('idApplyStatus')->default('1');
            $table->string('idRanking')->nullable();
            $table->string('idMyChance')->nullable();
            $table->string('idPleasantness')->nullable();
            $table->string('idPriority')->nullable();
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
