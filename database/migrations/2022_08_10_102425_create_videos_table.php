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
        Schema::create('videos', function (Blueprint $table) {
           $table->uuid('id')->unique();
            $table->uuid('user_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('percentage')->nullable();
            $table->bigInteger('total_views')->default(0);
            $table->string('duration')->nullable();
            $table->string('hashtag')->nullable();
            $table->uuid('video_type_id')->nullable();
            $table->string('path');      
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
        Schema::dropIfExists('videos');
    }
};
