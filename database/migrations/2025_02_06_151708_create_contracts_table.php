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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('register_number')->nullable();
            $table->string('phone_number');
            $table->string('phone_number_second')->nullable();
            $table->text('other_info')->nullable();
            $table->foreignId('apartment_id')->constrained('apartments'); 
            $table->foreignId('user_id')->constrained('users'); 
            $table->decimal('rent_amount', 10, 2);
            $table->decimal('deposit_amount', 10, 2)->nullable();
            $table->decimal('late_fee_amount', 10, 2)->nullable();
            $table->text('payment_schedule'); 
            $table->integer('status')->default(1)->nullable(); 
            $table->integer('contract_other_info')->default(1)->nullable(); 
            $table->date('contract_start_date');
            $table->date('contract_end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};