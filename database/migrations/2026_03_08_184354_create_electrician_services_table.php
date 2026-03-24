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
        Schema::create('electrician_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electrician_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 8, 2)->nullable(); // Custom price for this electrician
            $table->integer('duration_minutes')->nullable(); // Custom duration for this electrician
            $table->timestamps();
            
            // Prevent duplicate entries
            $table->unique(['electrician_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electrician_services');
    }
};