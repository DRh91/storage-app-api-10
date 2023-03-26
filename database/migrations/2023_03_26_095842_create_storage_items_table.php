<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('storage_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_barcode_info')->nullable(false);
            $table->foreign('id_barcode_info')->references('id')->on('barcode_infos')->onDelete('RESTRICT');
            $table->date("best_before_date")->nullable(true);
            $table->integer('state')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_items');
    }
};
