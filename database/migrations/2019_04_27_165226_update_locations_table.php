<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->integer('sunday')->after('end_time')->default(0);
            $table->integer('monday')->after('sunday')->default(0);
            $table->integer('tuesday')->after('monday')->default(0);
            $table->integer('wednesday')->after('tuesday')->default(0);
            $table->integer('thursday')->after('wednesday')->default(0);
            $table->integer('friday')->after('thursday')->default(0);
            $table->integer('saturday')->after('friday')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('sunday');
            $table->dropColumn('monday');
            $table->dropColumn('tuesday');
            $table->dropColumn('wednesday');
            $table->dropColumn('thursday');
            $table->dropColumn('friday');
            $table->dropColumn('saturday');
    }
}
