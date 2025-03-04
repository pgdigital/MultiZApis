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
        Schema::create('instance_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instance_id')->constrained('instances');
            $table->foreignId('client_id')->constrained('clients');
            $table->string('number');
            $table->string('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instance_messages');
    }
};
