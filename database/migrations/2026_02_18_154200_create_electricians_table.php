<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('electricians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name');
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('license_number')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->json('service_areas')->nullable();
            $table->integer('years_experience')->nullable();
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('electricians');
    }
};