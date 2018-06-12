<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->primary('id');
            $table->string('name')->nullable(false);
            $table->uuid('cat_id')->nullable(false);
            $table->string('latest_image');
            $table->uuid('location_id')->nullable(false);

            $table->uuid('department_id')->nullable(true)->default(null);
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            $table->json('specifications');
            $table->boolean('is_available')->default(true);
            $table->dateTime('deleted_at')->nullable(true)->default(null);
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
        Schema::dropIfExists('assets');
    }
}
