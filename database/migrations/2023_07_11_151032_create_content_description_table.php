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
        Schema::create('contents_description', function (Blueprint $table) {
            $table->bigInteger('contents_id', false);
            $table->bigInteger('language_id', false);

            $table->string('slug')->nullable();
            $table->text('description')->nullable();

            $table->string('name');
            $table->string('meta_title');
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();

            $table->json('datas')->nullable();

            $table->integer('created_by');
            $table->integer('updated_by')->nullable();

            $table->timestamps();

            $table->primary(['contents_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_description');
    }
};
