<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barcode_infos', function (Blueprint $table) {

            # id
            $table->bigIncrements('id');

            # barcode
            $table->string('barcode')->unique();

            # name
            $table->string('name')->nullable(false);

            # brand
            $table->string('brand')->nullable(false);

            # category foreign key
            $table->unsignedBigInteger('id_category')->nullable(true);
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('RESTRICT');

            # is_custom
            $table->boolean('is_custom')->nullable(true)->default(false);

            # image_url
            $table->mediumText('image_url')->nullable(true);

            # keywords
            $table->mediumText('keywords')->nullable(true);

            # unit and unit quantity
            $table->string('unit')->nullable(true);
            $table->integer('unit_quantity')->nullable(true);
            $table->integer('unit_quantity_drained')->nullable(true);

            # shopping quantity
            $table->integer('shopping_quantity')->nullable(false)->default(0);

            # ratings
            $table->json('ratings')->nullable(true);

            # shelf
            $table->integer('shelf')->nullable(true);

            # timestamps
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barcode_infos');
    }
};
