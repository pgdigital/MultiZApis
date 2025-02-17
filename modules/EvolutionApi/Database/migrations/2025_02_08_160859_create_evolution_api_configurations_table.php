<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evolution_api_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('identification');
            $table->string('api_url');
            $table->string('global_token_api');
            $table->integer('quantity_instances')->default(0);
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evolution_api_configurations');
    }
};
