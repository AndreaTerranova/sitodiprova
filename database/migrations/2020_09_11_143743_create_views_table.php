<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chapter_id', false, true);
            $table->string('ip');
            $table->timestamps();

            $table->unique(['chapter_id', 'ip']);
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('views');
    }
};
