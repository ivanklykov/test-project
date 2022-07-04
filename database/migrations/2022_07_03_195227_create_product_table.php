<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)
                ->nullable(false);

            $table->decimal('price', 10,2, true)
                ->nullable(false);

            $table->boolean('status')
                ->nullable(false)
                ->default(true);

            $table->boolean('is_archive')
                ->default(false);

            $table->index('name','IDX_PRODUCT_NAME');
            $table->index('price', 'IDX_PRODUCT_PRICE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
