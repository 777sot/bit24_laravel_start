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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
//            $table->string('TITLE');
//            $table->string('BTX_TITLE');
//            $table->string('CRM_TYPE');
//            $table->string('type');
//            $table->string('isRequired');
//            $table->string('isReadOnly');
//            $table->string('isImmutable');
//            $table->string('isMultiple');
//            $table->string('isDynamic');
//            $table->string('settings')->nullable();
//            $table->string('formLabel')->nullable();
//            $table->string('listLabel')->nullable();
//            $table->string('filterLabel')->nullable();
//            $table->string('url')->nullable();
            $table->string('FIELD_NAME');
            $table->string('CRM_TYPE');
            $table->string('EDIT_FORM_LABEL');
            $table->string('LIST_COLUMN_LABEL');
            $table->string('USER_TYPE_ID');
            $table->boolean('MULTIPLE')->default(0);
            $table->string('LIST')->nullable();
            $table->string('XML_ID');
            $table->text('SETTINGS')->nullable();
            $table->string('member_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
