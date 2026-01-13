<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
public function boot(): void
{
    // 🔽 デバッグ用にルート登録をここでも実行
    $this->app->booted(function () {
        require base_path('routes/web.php');
    });
}

}
