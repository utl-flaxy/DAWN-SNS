<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // posts が無いなら何もしない
        if (!Schema::hasTable('posts')) {
            return;
        }

        // body が無くて content があるなら rename
        if (!Schema::hasColumn('posts', 'body') && Schema::hasColumn('posts', 'content')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->renameColumn('content', 'body');
            });
        }

        // body も content も無いなら body を追加
        if (!Schema::hasColumn('posts', 'body')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->text('body')->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('posts')) {
            return;
        }

        // down では元に戻す（必要なら）
        if (Schema::hasColumn('posts', 'body') && !Schema::hasColumn('posts', 'content')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->renameColumn('body', 'content');
            });
        }
    }
};
