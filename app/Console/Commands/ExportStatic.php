<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

/**
 * Renders every page of the sketch to plain HTML in ./dist so it can be
 * hosted on any static host (Render Static Site, Netlify, cPanel…).
 *
 *   php artisan export:static
 *
 * English lives at /, the other languages at /ta, /ml, /hi.
 */
class ExportStatic extends Command
{
    protected $signature = 'export:static {--out=dist}';
    protected $description = 'Export the Arusuvai sketch as a static website';

    public function handle(): int
    {
        $out  = base_path($this->option('out'));
        $site = rtrim(config('arusuvai.site_url'), '/');

        $pages = [
            '/', '/menu', '/book-now', '/meal-change', '/login', '/register',
            '/payment/success', '/payment/cancel',
            '/account', '/account/track', '/account/subscription', '/account/rewards', '/account/notifications', '/account/profile',
            '/admin', '/admin/subscribers', '/admin/deliveries', '/admin/menu', '/admin/payments', '/admin/marketing', '/admin/notifications',
        ];
        $locales = array_keys(config('arusuvai.languages'));

        File::deleteDirectory($out);
        File::ensureDirectoryExists($out);
        File::copyDirectory(public_path('assets'), "$out/assets");
        foreach (['favicon.ico', 'robots.txt'] as $f) {
            if (File::exists(public_path($f))) File::copy(public_path($f), "$out/$f");
        }

        URL::forceRootUrl($site);
        config(['arusuvai.static' => true]);
        $kernel = app(HttpKernel::class);
        $count = 0;

        foreach ($locales as $loc) {
            $prefix = $loc === 'en' ? '' : "/$loc";
            config(['arusuvai.force_locale' => $loc, 'arusuvai.static_base' => $prefix]);

            foreach ($pages as $path) {
                $request = Request::create($site . $path, 'GET');
                $response = $kernel->handle($request);
                if ($response->getStatusCode() !== 200) {
                    $this->error("$loc $path → " . $response->getStatusCode());
                    continue;
                }
                $html = $this->rewrite($response->getContent(), $site, $prefix, $path, $locales);
                $file = $out . $prefix . ($path === '/' ? '' : $path) . '/index.html';
                File::ensureDirectoryExists(dirname($file));
                File::put($file, $html);
                $kernel->terminate($request, $response);
                $count++;
            }
        }

        // Simple 404 that sends visitors home
        File::put("$out/404.html", '<!doctype html><meta charset="utf-8"><meta http-equiv="refresh" content="0;url=/"><title>Arusuvai Mess</title><a href="/">Arusuvai Mess</a>');

        $this->info("Exported $count pages to " . $this->option('out') . '/');
        return self::SUCCESS;
    }

    /** Turn absolute app URLs in attributes into static, locale-aware paths. */
    private function rewrite(string $html, string $site, string $prefix, string $path, array $locales): string
    {
        $q = preg_quote($site, '#');

        // Assets are shared by all languages
        $html = preg_replace('#(href|src)="' . $q . '/assets/#', '$1="/assets/', $html);

        // Language switcher keeps the visitor on the same page
        $html = preg_replace_callback('#href="' . $q . '/lang/([a-z]{2})"#', function ($m) use ($path) {
            $p = $m[1] === 'en' ? '' : '/' . $m[1];
            return 'href="' . ($p . ($path === '/' ? '/' : $path . '/')) . '"';
        }, $html);

        // Internal links & form actions → /{locale}/page/
        $html = preg_replace_callback('#(href|action)="' . $q . '(/[^"?\#]*)?([?\#][^"]*)?"#', function ($m) use ($prefix) {
            $p = $m[2] ?? '';
            $p = ($p === '' || $p === '/') ? '/' : rtrim($p, '/') . '/';
            return $m[1] . '="' . $prefix . $p . ($m[3] ?? '') . '"';
        }, $html);

        return $html;
    }
}
