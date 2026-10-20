<?php

namespace App\Http\Middleware;

use Closure;

class MinifyHtml
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Yanıt HTML değilse veya bir hata sayfasıysa dokunma
        if ($this->isHtmlResponse($response)) {
            $html = $response->getContent();
            
            // Güvenli HTML sıkıştırma (Tasarımı bozmaz, sadece boşlukları siler)
            $search = [
                '/\>[^\S ]+/s',     // tag'ler sonrasındaki boşluklar
                '/[^\S ]+\</s',     // tag'ler öncesindeki boşluklar
                '/(\s)+/s',         // birden fazla boşluğu tek boşluğa indir
                '/).)*-->/s' // HTML yorumlarını sil (IE tagları hariç)
            ];

            $replace = [
                '>',
                '<',
                '\\1',
                ''
            ];

            $html = preg_replace($search, $replace, $html);
            $response->setContent($html);
        }

        return $response;
    }

    protected function isHtmlResponse($response)
    {
        return $response->headers->has('Content-Type') &&
               strpos($response->headers->get('Content-Type'), 'text/html') !== false;
    }
}