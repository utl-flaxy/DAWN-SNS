<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('following_user_id'); // 自分
            $table->unsignedBigInteger('followed_user_id');  // 相手
            $table->timestamps();

            $table->unique(['following_user_id', 'followed_user_id']);

            $table->foreign('following_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('followed_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
