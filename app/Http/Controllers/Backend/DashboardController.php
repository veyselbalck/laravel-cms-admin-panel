<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use MadeITBelgium\SeoAnalyzer\SeoFacade as SEO;
use Spatie\Sitemap\SitemapGenerator;

class DashboardController extends ActionController
{
    public function index() {
        return view('panel.dashboard.index');
    }

    public function sitemap_generator(){
        SitemapGenerator::create(env("APP_URL"))->getSitemap()->writeToDisk('public2', 'sitemap.xml', true);
        return redirect()->route("home")->with("success", "Site haritası güncellendi.");
    }
}
