<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {

    public function up(): void
    {
        Schema::create('domain', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domain');
    }
};
