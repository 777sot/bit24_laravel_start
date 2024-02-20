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
        Schema::create('list_dependencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_field_id')->nullable()->index()->constrained('list_fields');
            $table->foreignId('field_id')->nullable()->index()->constrained('fields');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_dependencies');
    }
};
