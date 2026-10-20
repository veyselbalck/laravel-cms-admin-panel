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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();

            $table->integer('parent_id')->index('parent_id')->nullable()->default(0);

            $table->string('name', 255);
            $table->string('template', 255);
            $table->string('content_type', 255)->nullable();
            $table->string('image', 255)->nullable();

            $table->json('modules')->nullable();
            $table->json('datas')->nullable();

            $table->smallInteger('sort_order')->nullable();
            $table->boolean('status')->nullable()->default(1);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::unprepared("CREATE TRIGGER `DeleteContentsDescriptions` AFTER DELETE ON `contents` FOR EACH ROW DELETE FROM contents_description WHERE contents_description.contents_id = old.id;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content');
    }
};
