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
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('CRM_TYPE');
            $table->foreignId('field_id')->nullable()->index()->constrained('fields');
            $table->text('rule');
            $table->unsignedSmallInteger('rule_type');
            $table->boolean('show')->default('1');
            $table->string('member_id')->nullable();
            $table->string('block')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
