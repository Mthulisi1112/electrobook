<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
        {
            Schema::create('availability_slots', function (Blueprint $table) {
                $table->id();
            $table->foreignId('electrician_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');  // Should be time, not datetime
            $table->time('end_time');    // Should be time, not datetime
            $table->boolean('is_booked')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_pattern')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('availability_slots');
    }
};