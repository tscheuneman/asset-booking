<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->double('longitude', 15, 8)->nullable(false);
            $table->double('latitude', 15, 8)->nullable(false);
            $table->integer('asset_id')->nullable(false)->unique();
            $table->integer('building_id')->required();
            $table->integer('region_id')->required();
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
