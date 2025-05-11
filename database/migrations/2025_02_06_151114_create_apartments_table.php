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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->integer('status')->default(1)->nullable(); 
            $table->date('repair_date')->nullable(); 
            $table->foreignId('user_id')->constrained('users'); 
            $table->string('size')->nullable(); 
            $table->string('file')->nullable(); 
            $table->decimal('rent_price', 10, 2)->nullable();
            $table->text('other_info')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};