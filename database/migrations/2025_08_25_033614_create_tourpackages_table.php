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
        Schema::create('tourpackages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 0)->default(0);
            $table->text('price_detail')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('itenary_description')->nullable();
            $table->text('itenary_detail')->nullable();
            $table->text('policy_description')->nullable();
            $table->text('policy_detail')->nullable();
            $table->text('info_description')->nullable();
            $table->text('info_detail')->nullable();
            $table->string('banner')->nullable();
            $table->foreignId('tourpackagecat_id')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourpackages');
    }
};
