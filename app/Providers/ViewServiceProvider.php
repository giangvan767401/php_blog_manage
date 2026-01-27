<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer(['news.index', 'news.show'], function ($view) {
            $trendingNews = \App\Models\News::where('status', 'approved')
                ->where('created_at', '>=', now()->subDays(7))
                ->orderBy('views', 'desc')
                ->take(5)
                ->get();
            $view->with('trendingNews', $trendingNews);
        });
    }
}
