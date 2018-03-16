<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Specification;

class CreateSpecificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specifications', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->primary('id');
            $table->string('name')->isNullable(false);
            $table->string('slug')->isNullable(false);
            $table->string('type')->isNullable(false);
            $table->boolean('required')->default(false);
            $table->json('options');
            $table->timestamps();
        });


        $spec = new Specification();
            $spec->name = 'Price';
            $spec->slug = "price";
            $spec->type = "number";
            $spec->required = true;
            $spec->options = '[{"label": "", "value": ""}]';
            $spec->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specifications');
    }
}
