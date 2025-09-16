<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = Cache::remember('sitemap', now()->addHours(12), function () {
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

            // Home page
            $this->addUrl($xml, route('home'), '1.0', 'daily');

            // Categories page
            $this->addUrl($xml, route('categories.index'), '0.9', 'weekly');

            // Legal pages
            $this->addUrl($xml, route('legal.terms'), '0.3', 'monthly');
            $this->addUrl($xml, route('legal.privacy'), '0.3', 'monthly');
            $this->addUrl($xml, route('legal.refunds'), '0.3', 'monthly');

            // Active categories
            $categories = Category::active()->get();
            foreach ($categories as $category) {
                $this->addUrl($xml, route('category.show', $category->slug), '0.8', 'weekly', $category->updated_at);
            }

            // Active products
            $products = Product::with('category')->where('is_active', true)->get();
            foreach ($products as $product) {
                $this->addUrl($xml, route('product.show', $product->slug), '0.7', 'weekly', $product->updated_at);
            }

            return $xml->asXML();
        });

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    private function addUrl(\SimpleXMLElement $xml, string $url, string $priority = '0.5', string $changefreq = 'monthly', ?Carbon $lastmod = null): void
    {
        $urlElement = $xml->addChild('url');
        $urlElement->addChild('loc', $url);
        $urlElement->addChild('priority', $priority);
        $urlElement->addChild('changefreq', $changefreq);
        
        if ($lastmod) {
            $urlElement->addChild('lastmod', $lastmod->toISOString());
        } else {
            $urlElement->addChild('lastmod', now()->toISOString());
        }
    }
}