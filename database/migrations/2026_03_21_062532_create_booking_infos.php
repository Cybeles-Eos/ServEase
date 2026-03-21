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
        Schema::create('booking_infos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')
                  ->constrained('tbl_services')
                  ->cascadeOnDelete();

            $table->foreignId('customer_id')
                  ->constrained('tbl_customers')
                  ->cascadeOnDelete();

            //Fill up for       
            $table->string('fname', 255);
            $table->string('lname', 255);
            $table->text('address')->nullable();
            $table->string('email', 255);
            $table->string('number', 50);
            $table->date('date')->nullable();
            $table->time('time')->nullable();

            $table->string('status', 20)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_infos');
    }
};
