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
        Schema::create('capsules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('message');
            $table->string('image')->nullable();
            $table->timestampTz('open_at')->index();
            $table->timestampTz('opened_at')->nullable()->index();
            $table->boolean('is_archived')->default(false)->index();
            $table->timestamps();

            $table->index(['user_id', 'open_at']);
            $table->index(['user_id', 'is_archived']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capsules');
    }
};
