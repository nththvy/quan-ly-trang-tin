<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Article;
use App\Models\Category;

use App\Policies\ArticlePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    protected $policies = [
        Article::class => ArticlePolicy::class,
    ];
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('getCreate', [ArticlePolicy::class, 'getCreate']);
        Gate::define('postCreate', [ArticlePolicy::class, 'postCreate']);
        Gate::define('getUpdate', [ArticlePolicy::class, 'getUpdate']);
        Gate::define('postUpdate', [ArticlePolicy::class, 'postUpdate']);
        Gate::define('requestEdit', [ArticlePolicy::class, 'requestEdit']);
        Gate::define('approveEdit', [ArticlePolicy::class, 'approveEdit']);
        Gate::define('delete-article', [ArticlePolicy::class, 'delete']);
        Gate::define('postSend', [ArticlePolicy::class, 'postSend']);
        Gate::define('return', [ArticlePolicy::class, 'return']);
        Gate::define('unpublish', [ArticlePolicy::class, 'unpublish']);

        // View Composer: Truyền dữ liệu phổ biến cho tất cả các view
        View::composer('layouts.frontend', function ($view) {
            $articles = Article::with(['category', 'status', 'writer'])
                ->whereHas('status', function ($query) {
                    $query->where('status', 'published');
                })
                ->latest()
                ->take(6)
                ->get();

            $view->with('articles', $articles);
        });

        View::composer('*', function ($view) {
            $categories_home = Category::whereIn('name', [
                'Kiến tạo xã hội số',
                'Tin báo chí',
                'Thông cáo báo chí',
                'MWC',
                'Công bố thông tin',
                'Trách nhiệm xã hội'
            ])->get();
            $view->with('categories_home', $categories_home);
        });
        Paginator::useBootstrap();
    }
}
