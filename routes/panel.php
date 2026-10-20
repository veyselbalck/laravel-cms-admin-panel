<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\UsersController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\LanguagesController;
use App\Http\Controllers\backend\ContentsController;
use App\Http\Controllers\backend\PostsController;
use App\Http\Controllers\backend\ProductsController;
use App\Http\Controllers\backend\ModulesController;
use App\Http\Controllers\backend\CityController;
use App\Http\Controllers\backend\CountryController;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\backend\ErrorsController;
use App\Http\Controllers\backend\RolesController;
use App\Http\Controllers\backend\JsonController;
use App\Http\Controllers\backend\SeoRedirectController;
use App\Http\Controllers\backend\TestimonialController;
use App\Http\Controllers\backend\ContactsController;

/*
|--------------------------------------------------------------------------
| Panel Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin'], function () {
    app()->setLocale("tr");
    Auth::routes(['confirm' => false, 'register' => false]);

//    Route::get('/', function () {
//        return view('welcome');
//    });
    Route::redirect('/', '/admin/login');

    Route::middleware(['auth', 'auth.status'])->group(function () {
        Route::get('/home', [DashboardController::class, 'index'])->name('home');
        Route::get('/home/sitemap', [DashboardController::class, 'sitemap_generator'])->name('sitemap_generator');
        Route::get('json/{slug?}', [JsonController::class, 'show'])->where('slug','.*')->name('json');
        Route::put('json/{slug?}', [JsonController::class, 'show'])->where('slug','.*')->name('json');
        Route::middleware(['auth.permission'])->group(function (){
            Route::resources([
                'users'         => UsersController::class,
                'settings'      => SettingController::class,
                'languages'     => LanguagesController::class,
                'contents'      => ContentsController::class,
                'posts'         => PostsController::class,
                'products'      => ProductsController::class,
                'modules'       => ModulesController::class,
                'city'          => CityController::class,
                'country'       => CountryController::class,
                'roles'         => RolesController::class,
                'seo_redirect'  => SeoRedirectController::class,
                'testimonial'   => TestimonialController::class,
                'contacts'      => ContactsController::class,
            ]);
        });

        Route::get('/copy/content/{id}', [ContentsController::class, 'copy'])->name('contents.copy');
        Route::get('/copy/product/{id}', [ProductsController::class, 'copy'])->name('products.copy');
        Route::get('/copy/module/{id}', [ModulesController::class, 'copy'])->name('modules.copy');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/error/permission', [ErrorsController::class, 'index'])->name('error.permission');
    });
});
