<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Controllers\SubscriberController;

Auth::routes();
Route::name('frontend.')->group(function () {
    // Trang chủ
    Route::get('/', [HomeController::class, 'getHome'])->name('home');
    Route::get('/home', [HomeController::class, 'getHome'])->name('home');
    Route::get('/article/{category_slug}/{article_slug}', [HomeController::class, 'getArticle_Detail'])->name('article.show');
    Route::get('/category', [HomeController::class, 'getAllCategories'])->name('all_categories');
    Route::get('/category/{slug}', [HomeController::class, 'getArticles_Category'])->name('categories.show');
    Route::post('/comment/{article}', [CommentController::class, 'postComment'])->name('comment.store');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/hot-articles', [HomeController::class, 'hotArticles'])->name('articles.hot');
    Route::get('/latest-articles', [HomeController::class, 'latestArticles'])->name('articles.latest');
    Route::delete('/my-comment/delete/{id}', [HomeController::class, 'userDelete'])->name('comment.delete');
    Route::get('/tag/{slug}', [HomeController::class, 'getArticles_Tag'])->name('tags.show');

    Route::post('/subscribe', [SubscriberController::class, 'subscribe'])->name('subscriber.subscribe');
    Route::get('/unsubscribe/{token}', [SubscriberController::class, 'unsubscribe'])->name('subscriber.unsubscribe');
});
Route::prefix('user')->name('user.')->middleware('auth', \App\Http\Middleware\UserMiddleware::class)->group(function () {
    //Trang chu
    Route::get('/profile', [UserController::class, 'getProfile'])->name('profile');
    Route::post('/profile', [UserController::class, 'postProfile'])->name('profile');
});
Route::prefix('admin')->name('admin.')->middleware('auth', \App\Http\Middleware\AdminMiddleware::class)->group(function () {
    // Trang chủ
    Route::get('/', [AdminController::class, 'getHome'])->name('home');
    Route::get('/home', [AdminController::class, 'getHome'])->name('home');

    // Quản lý danh mục
    //Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
    Route::middleware(PermissionMiddleware::class . ':admin.categories')->group(function () {
        Route::get('/categories', [CategoryController::class, 'getList'])
            ->name('categories');
        Route::get('/categories/create', [CategoryController::class, 'getCreate'])
            ->name('categories.create')
            ->middleware(PermissionMiddleware::class . ':admin.categories.create');
        Route::post('/categories/create', [CategoryController::class, 'postCreate'])
            ->middleware(PermissionMiddleware::class . ':admin.categories.create');
        Route::get('/categories/update/{id}', [CategoryController::class, 'getUpdate'])
            ->name('categories.update')
            ->middleware(PermissionMiddleware::class . ':admin.categories.update');
        Route::post('/categories/update/{id}', [CategoryController::class, 'postUpdate'])
            ->middleware(PermissionMiddleware::class . ':admin.categories.update');
        Route::get('/categories/delete/{id}', [CategoryController::class, 'getDelete'])
            ->name('categories.delete')
            ->middleware(PermissionMiddleware::class . ':admin.categories.delete');
    });

    // Quản lý từ khóa
    Route::middleware(PermissionMiddleware::class . ':admin.tags')->group(function () {
        Route::get('/tags', [TagController::class, 'getList'])
            ->name('tags');

        Route::get('/tags/create', [TagController::class, 'getCreate'])
            ->name('tags.create')
            ->middleware(PermissionMiddleware::class . ':admin.tags.create');

        Route::post('/tags/create', [TagController::class, 'postCreate'])
            ->middleware(PermissionMiddleware::class . ':admin.tags.create');

        Route::get('/tags/update/{id}', [TagController::class, 'getUpdate'])
            ->name('tags.update')
            ->middleware(PermissionMiddleware::class . ':admin.tags.update');

        Route::post('/tags/update/{id}', [TagController::class, 'postUpdate'])
            ->middleware(PermissionMiddleware::class . ':admin.tags.update');

        Route::get('/tags/delete/{id}', [TagController::class, 'getDelete'])
            ->name('tags.delete')
            ->middleware(PermissionMiddleware::class . ':admin.tags.delete');
    });

    // Quản lý tình trạng
    Route::middleware(PermissionMiddleware::class . ':admin.statuses')->group(function () {
        Route::get('/statuses', [StatusController::class, 'getList'])
            ->name('statuses');

        Route::get('/statuses/create', [StatusController::class, 'getCreate'])
            ->name('statuses.create')
            ->middleware(PermissionMiddleware::class . ':admin.statuses.create');

        Route::post('/statuses/create', [StatusController::class, 'postCreate'])
            ->middleware(PermissionMiddleware::class . ':admin.statuses.create');

        Route::get('/statuses/update/{id}', [StatusController::class, 'getUpdate'])
            ->name('statuses.update')
            ->middleware(PermissionMiddleware::class . ':admin.statuses.update');

        Route::post('/statuses/update/{id}', [StatusController::class, 'postUpdate'])
            ->middleware(PermissionMiddleware::class . ':admin.statuses.update');

        Route::get('/statuses/delete/{id}', [StatusController::class, 'getDelete'])
            ->name('statuses.delete')
            ->middleware(PermissionMiddleware::class . ':admin.statuses.delete');
    });

    // Quản lý vai trò
    Route::middleware(PermissionMiddleware::class . ':admin.roles')->group(function () {
        Route::get('/roles', [RoleController::class, 'getList'])
            ->name('roles');

        Route::get('/roles/create', [RoleController::class, 'getCreate'])
            ->name('roles.create')
            ->middleware(PermissionMiddleware::class . ':admin.roles.create');

        Route::post('/roles/create', [RoleController::class, 'postCreate'])
            ->middleware(PermissionMiddleware::class . ':admin.roles.create');

        Route::get('/roles/update/{id}', [RoleController::class, 'getUpdate'])
            ->name('roles.update')
            ->middleware(PermissionMiddleware::class . ':admin.roles.update');

        Route::post('/roles/update/{id}', [RoleController::class, 'postUpdate'])
            ->middleware(PermissionMiddleware::class . ':admin.roles.update');

        Route::get('/roles/delete/{id}', [RoleController::class, 'getDelete'])
            ->name('roles.delete')
            ->middleware(PermissionMiddleware::class . ':admin.roles.delete');
    });

    // Quản lý người dùng
    Route::middleware(PermissionMiddleware::class . ':admin.users')->group(function () {
        Route::get('/users', [UserController::class, 'getList'])
            ->name('users');

        Route::get('/users/create', [UserController::class, 'getCreate'])
            ->name('users.create')
            ->middleware(PermissionMiddleware::class . ':admin.users.create');

        Route::post('/users/create', [UserController::class, 'postCreate'])
            ->middleware(PermissionMiddleware::class . ':admin.users.create');

        Route::get('/users/update/{id}', [UserController::class, 'getUpdate'])
            ->name('users.update')
            ->middleware(PermissionMiddleware::class . ':admin.users.update');

        Route::post('/users/update/{id}', [UserController::class, 'postUpdate'])
            ->middleware(PermissionMiddleware::class . ':admin.users.update');

        Route::get('/users/delete/{id}', [UserController::class, 'getDelete'])
            ->name('users.delete')
            ->middleware(PermissionMiddleware::class . ':admin.users.delete');
    });

    //});
    // Quản lý bài viết
    Route::middleware(PermissionMiddleware::class . ':admin.articles')->group(function () {
        Route::get('/articles', [ArticleController::class, 'getList'])
            ->name('articles');

        Route::get('/articles/create', [ArticleController::class, 'getCreate'])
            ->name('articles.create')
            ->middleware(PermissionMiddleware::class . ':admin.articles.create');

        Route::post('/articles/create', [ArticleController::class, 'postCreate'])
            ->middleware(PermissionMiddleware::class . ':admin.articles.create');

        Route::get('/articles/update/{id}', [ArticleController::class, 'getUpdate'])
            ->name('articles.update')
            ->middleware(PermissionMiddleware::class . ':admin.articles.update');

        Route::post('/articles/update/{id}', [ArticleController::class, 'postUpdate'])
            ->middleware(PermissionMiddleware::class . ':admin.articles.update');

        Route::delete('/articles/delete/{id}', [ArticleController::class, 'delete'])
            ->name('articles.delete')
            ->middleware(PermissionMiddleware::class . ':admin.articles.delete');

        Route::post('/articles/upload-image', [ArticleController::class, 'uploadImage'])
            ->name('articles.uploadImage')
            ->middleware(PermissionMiddleware::class . ':admin.articles.upload');

        Route::get('/check-title', [ArticleController::class, 'checkTitle'])
            ->name('check.title')
            ->middleware(PermissionMiddleware::class . ':admin.articles');

        Route::get('/articles/{id}/note', [NoteController::class, 'getNote'])
            ->name('articles.note')
            ->middleware(PermissionMiddleware::class . ':admin.articles.note');

        Route::post('/articles/send/{id}', [ArticleController::class, 'postSend'])
            ->name('articles.send')
            ->middleware(PermissionMiddleware::class . ':admin.articles.send');

        Route::post('/articles/{id}/request-edit', [ArticleController::class, 'requestEdit'])
            ->name('articles.request_edit')
            ->middleware(PermissionMiddleware::class . ':admin.articles.request_edit');

        Route::post('/articles/{id}/approve-edit', [ArticleController::class, 'approveEdit'])
            ->name('articles.approve_edit')
            ->middleware(PermissionMiddleware::class . ':admin.articles.approve_edit');

        Route::post('/articles/{id}/return', [ArticleController::class, 'postReturn'])
            ->name('articles.return')
            ->middleware(PermissionMiddleware::class . ':admin.articles.return');

        Route::post('/articles/{id}/unpublish', [ArticleController::class, 'unpublish'])
            ->name('articles.unpublish')
            ->middleware(PermissionMiddleware::class . ':admin.articles.unpublish');
    });



    // Quản lý bình luận
    Route::middleware(PermissionMiddleware::class . ':admin.comments')->group(function () {
        Route::get('/comments', [CommentController::class, 'getList'])->name('comments');

        Route::get('/comments/approve/{id}', [CommentController::class, 'getApprove'])
            ->name('comments.approve')
            ->middleware(PermissionMiddleware::class . ':admin.comments.approve');

        Route::delete('/comments/delete/{id}', [CommentController::class, 'getDelete'])
            ->name('comments.delete')
            ->middleware(PermissionMiddleware::class . ':admin.comments.delete');
    });
    //Route::get('/comments', [CommentController::class, 'getList'])->name('comments');
    //Route::get('/comments/approve/{id}', [CommentController::class, 'getApprove'])->name('comments.approve');
    //Route::delete('/comments/delete/{id}', [CommentController::class, 'getDelete'])->name('comments.delete');

    // Subscribers
    Route::middleware(PermissionMiddleware::class . ':admin.subscribers')->group(function () {
        Route::get('/subscribers', [SubscriberController::class, 'getList'])
            ->name('subscribers');

        Route::get('/subscribers/delete/{id}', [SubscriberController::class, 'getDelete'])
            ->name('subscribers.delete')
            ->middleware(PermissionMiddleware::class . ':admin.subscribers.delete');
    });
});
