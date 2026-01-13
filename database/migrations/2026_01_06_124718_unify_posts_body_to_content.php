<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // content が無ければ作る（念のため）
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'content')) {
                $table->text('content')->nullable()->after('user_id');
            }
        });

        // body -> content にコピー（contentが空のものだけ）
        if (Schema::hasColumn('posts', 'body')) {
            DB::statement("UPDATE posts SET content = body WHERE (content IS NULL OR content = '')");
        }

        // body を削除（contentに統一）
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'body')) {
                $table->dropColumn('body');
            }
        });
    }

    public function down(): void
    {
        // 戻す：body を復活させて content をコピーし、content を削除
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'body')) {
                $table->text('body')->nullable()->after('user_id');
            }
        });

        if (Schema::hasColumn('posts', 'content')) {
            DB::statement("UPDATE posts SET body = content WHERE (body IS NULL OR body = '')");
        }

        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'content')) {
                $table->dropColumn('content');
            }
        });
    }
};
