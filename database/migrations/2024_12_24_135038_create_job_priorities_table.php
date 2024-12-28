<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_priorities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('value')->comment('Cada valor tendra un valor de 100 incrementable -> 100, 200, 300 y asi... si se require crear una prioridad que debe estar entre la del valor 200 y 300, debe tener el valor intermedio osea 250. Estos valores determinan cual tiene mas relevancia que otra'); 
            $table->tinyInteger('status')->default(1); // Añadir el campo status con valor por defecto 1
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
        Schema::dropIfExists('job_priorities');
    }
}
