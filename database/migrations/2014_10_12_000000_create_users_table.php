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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_group_id')->nullable();
            $table->string('password');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('ip')->nullable();
            $table->string('role')->index();
            $table->boolean('status')->default(0)->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('created_by'); // kim ekledi
            $table->integer('updated_by')->unsigned()->nullable(); // kim güncelledi
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
