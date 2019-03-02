<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('address');
            $table->string('longitude');
            $table->string('latitude');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('type')->default(0); //0->persoana fizica;1->companie;2->parcare normala
            $table->string('details')->nullable();
            $table->integer('price');
            $table->rememberToken();
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
        Schema::dropIfExists('locations');
    }
}
