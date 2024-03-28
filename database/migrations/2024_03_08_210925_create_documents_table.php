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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Added
            $table->uuid('document_id')->unique();
            $table->unsignedBigInteger('producer_id');
            $table->string('file_path')->nullable();
            $table->enum('status', ['Ready for preview', 'Signing', 'Signed', 'Rejected'])->default('Ready for preview');
            $table->string('chain_address')->nullable();
            $table->unsignedBigInteger('verifier_id')->nullable();
            $table->string('signed_file_path')->nullable();
            $table->timestamps();
            $table->timestamp('verified_at')->nullable();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};