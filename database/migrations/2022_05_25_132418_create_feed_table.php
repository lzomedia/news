<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(1);
            $table->string('title')->index()->nullable();
            $table->string('url')->index()->nullable();
            $table->timestamp('sync')->index()->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
