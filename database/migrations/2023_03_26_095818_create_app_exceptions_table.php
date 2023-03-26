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
        Schema::create('app_exceptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class')->nullable(true);
            $table->longText('message')->nullable(true);
            $table->longText('stacktrace')->nullable(true);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_exceptions');
    }
};
