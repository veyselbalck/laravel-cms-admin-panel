<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\SitemapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Clear Cache (admin)
Route::post('/admin/clear-cache', [SitemapController::class, 'clearCache'])
    ->name('admin.clear-cache');

// Sitemap generate route (admin)
Route::get('/admin/generate-sitemap', [SitemapController::class, 'generate'])
    ->middleware('auth');

$languages = \App\Models\Panel\Languages::active()->count();
$prefix_route = $languages > 1 ? "{language?}/" : "";

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::middleware(['web'])->group(function () use ($prefix_route) {

    Route::post('/form-send/{id}', [\App\Http\Controllers\FrontendController::class, 'form'])->name('form-send');
    Route::post('/form/{service}', [\App\Http\Controllers\FrontendController::class, 'form2'])->name('form');

    // [DİNAMİK GLOBAL /tr/ YÖNLENDİRMESİ] URL'de /tr veya /tr/ ile başlayan her şeyi 301 ile yalın haline yönlendirir
    Route::redirect('/tr', '/', 301);
    Route::match(['get', 'post'], '/tr/{any}', function ($any) {
        return redirect('/' . $any, 301);
    })->where('any', '.*');

    // [DİNAMİK GLOBAL /tedaviler/ YÖNLENDİRMESİ] URL'de /tedaviler/ ile başlayan her şeyi 301 ile yalın haline fırlatır
    Route::match(['get', 'post'], '/tedaviler/{slug}', function ($slug) {
        return redirect('/' . $slug, 301);
    })->where('slug', '.*');


    // ── NET LOKASYON YÖNLENDİRMELERİ (GÜVENLİ LİMAN) ──────────────────────────────────
    // Sadece kaldırılan şubeleri yönlendiriyoruz, çalışan şubelere (leeds, sheffield vs.) asla dokunmuyoruz.
    
    // İngilizce Eski Şubeler
    Route::redirect('/en/locations/bristol', '/en/locations', 301);
    Route::redirect('/en/locations/watford', '/en/locations', 301);

    // Çekçe Eski Şubeler
    Route::redirect('/cs/pobocky/bristol', '/cs/pobocky', 301);
    Route::redirect('/cs/pobocky/watford', '/cs/pobocky', 301);

    // Türkçe Eski Şubeler
    Route::redirect('/lokasyonlar/bristol', '/lokasyonlar', 301);
    Route::redirect('/lokasyonlar/watford', '/lokasyonlar', 301);


    // Mevcut Statik Yeniden Yönlendirmeleriniz
    Route::redirect('/tr/tedaviler/dis-kaplama', '/dis-kaplama', 301);
    Route::redirect('/tr/tedaviler/dis-implanti', '/dis-implanti', 301);
    Route::redirect('/tr/tedaviler/dis-cekimi', '/dis-cekimi', 301);
    Route::redirect('/tr/tedaviler/hollywood-gulusu', '/hollywood-gulusu', 301);
    Route::redirect('/hollywood-smile', '/hollywood-gulusu', 301);
    Route::redirect('/konu/haberler', '/bloglar', 301);
    Route::redirect('/konu/estetik', '/bloglar', 301);
    Route::redirect('/tr/bloglar/antalyada-uygun-fiyatli-ve-guvenilir-dis-tedavisi', '/bloglar/antalyada-uygun-fiyatli-ve-guvenilir-dis-tedavisi', 301);
    Route::redirect('/tr/bloglar/dis-implantlari-hakkinda-her-sey', '/bloglar/dis-implantlari-hakkinda-her-sey', 301);
    Route::redirect('/tr/bloglar/dis-turizmi-neden-turkiye', '/bloglar/dis-turizmi-neden-turkiye', 301);
    Route::redirect('/tr/bloglar/kaplamalar-ve-kuronlar-rehberi', '/bloglar/kaplamalar-ve-kuronlar-rehberi', 301);
    Route::redirect('/tr/bloglar/neden-med-antalya-turkiyedeki-ilk-tercihiniz', '/bloglar/neden-med-antalya-turkiyedeki-ilk-tercihiniz', 301);
    Route::redirect('/tr/bloglar/turkiyede-en-iyi-dis-tedavisi-med-antalya', '/bloglar/turkiyede-en-iyi-dis-tedavisi-med-antalya', 301);
    Route::redirect('/tr/tedaviler', '/tedaviler', 301);
    Route::redirect('/tr/lokasyonlar/Wycombe', '/lokasyonlar/Wycombe', 301);
    Route::redirect('/tr/lokasyonlar/chelmsford', '/lokasyonlar/chelmsford', 301);
    Route::redirect('/tr/lokasyonlar/edinburgh', '/lokasyonlar/edinburgh', 301);
    Route::redirect('/tr/lokasyonlar/leeds', '/lokasyonlar/leeds', 301);
    Route::redirect('/tr/lokasyonlar/sheffield', '/lokasyonlar/sheffield', 301);

    Route::group(['prefix' => $prefix_route], function () {

        Route::get('search', [\App\Http\Controllers\FrontendController::class, 'search'])->name('search');

        Route::domain('{subdomain}.' . config('app.url'))->group(function () {
            Route::get('{slug?}', [\App\Http\Controllers\FrontendController::class, 'subdomain'])
                ->where('slug', '.*')
                ->name('frontend.subdomain');
        });

        Route::get('{slug?}', [\App\Http\Controllers\FrontendController::class, 'index'])
            ->where('slug', '.*')
            ->name('frontend');
    });
});