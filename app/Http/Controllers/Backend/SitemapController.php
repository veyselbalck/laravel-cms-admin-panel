<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SitemapController extends Controller
{
    const HOME_CONTENT_ID = 1;

    public function generate()
    {
        $baseUrl = rtrim(url('/'), '/');

        $languages = DB::table('languages')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('id');

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $addedUrls = [];

        foreach ($languages as $langId => $language) {

            // Her dil için önce tüm parent slug'larını bir map'e al
            // parent_id => parent_slug (o dildeki)
            $parentSlugs = DB::table('contents')
                ->join('contents_description', function ($join) use ($langId) {
                    $join->on('contents.id', '=', 'contents_description.contents_id')
                         ->where('contents_description.language_id', '=', $langId);
                })
                ->where('contents.status', 1)
                ->whereNotNull('contents_description.slug')
                ->where('contents_description.slug', '!=', '')
                ->select('contents.id', 'contents_description.slug')
                ->get()
                ->pluck('slug', 'id'); // [content_id => slug]

            // Aktif içerikleri al (parent_id de dahil)
            $items = DB::table('contents')
                ->join('contents_description', function ($join) use ($langId) {
                    $join->on('contents.id', '=', 'contents_description.contents_id')
                         ->where('contents_description.language_id', '=', $langId);
                })
                ->where('contents.status', 1)
                ->whereNotNull('contents_description.slug')
                ->where('contents_description.slug', '!=', '')
                ->select(
                    'contents.id as content_id',
                    'contents.parent_id',
                    'contents_description.slug',
                    DB::raw('COALESCE(contents.updated_at, contents.created_at) as last_updated')
                )
                ->get();

            foreach ($items as $item) {
                $slug = trim($item->slug);

                if (!$slug) continue;
                if (str_contains($slug, ' '))    continue;
                if (str_contains($slug, 'http')) continue;
                if (strlen($slug) > 200)         continue;

                // Parent'ın slug'ı varsa öne ekle (örn: bloglar/kaplamalar-ve-kuronlar-rehberi)
                $parentId = $item->parent_id;
                if ($parentId && isset($parentSlugs[$parentId])) {
                    $fullSlug = $parentSlugs[$parentId] . '/' . $slug;
                } else {
                    $fullSlug = $slug;
                }

                // URL oluştur
                if ($language->code === 'tr') {
                    $url = $baseUrl . '/' . $fullSlug;
                } else {
                    $url = $baseUrl . '/' . $language->code . '/' . $fullSlug;
                }

                if (in_array($url, $addedUrls)) continue;
                $addedUrls[] = $url;

                $priority = ($item->content_id == self::HOME_CONTENT_ID) ? '1.0' : '0.8';

                $lastmod = $item->last_updated
                    ? date('Y-m-d', strtotime($item->last_updated))
                    : date('Y-m-d');

                $xml .= "    <url>\n";
                $xml .= "        <loc>" . htmlspecialchars($url, ENT_XML1, 'UTF-8') . "</loc>\n";
                $xml .= "        <lastmod>{$lastmod}</lastmod>\n";
                $xml .= "        <changefreq>weekly</changefreq>\n";
                $xml .= "        <priority>{$priority}</priority>\n";
                $xml .= "    </url>\n";
            }
        }

        $xml .= '</urlset>';

        file_put_contents(public_path('sitemap.xml'), $xml);

        return response("Sitemap başarıyla oluşturuldu ✅ — " . count($addedUrls) . " URL yazıldı.")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function clearCache()
{
    try {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        
        return back()->with('success', 'Site önbelleği başarıyla temizlendi!');
    } catch (\Exception $e) {
        return back()->with('error', 'Önbellek temizlenirken hata oluştu: ' . $e->getMessage());
    }
}
}

