<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_redirect', function (Blueprint $table) {
            $table->id();
            $table->string("title", 255);
            $table->string("address", 255);
            $table->string("redirect", 255);
            $table->string("http_status", 5);
            $table->integer('created_by')->unsigned()->default(0); // kim ekledi
            $table->integer('updated_by')->unsigned()->default(0); // kim güncelledi
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_redirect');
    }
};
