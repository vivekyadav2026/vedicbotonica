<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        // Standard static pages
        $staticUrls = [
            '/',
            '/about',
            '/shop',
            '/contact',
            '/terms',
            '/privacy',
            '/refund',
            '/cancellation',
            '/shipping'
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Add static URLs
        foreach ($staticUrls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . url($url) . '</loc>';
            $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>' . ($url == '/' ? '1.0' : '0.8') . '</priority>';
            $xml .= '</url>';
        }

        // Add categories
        foreach ($categories as $category) {
            $xml .= '<url>';
            $xml .= '<loc>' . url('/shop?categories[]=' . $category->id) . '</loc>';
            $xml .= '<lastmod>' . $category->updated_at->format('Y-m-d') . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        // Add products
        foreach ($products as $product) {
            $xml .= '<url>';
            $xml .= '<loc>' . url('/product/' . $product->slug) . '</loc>';
            $xml .= '<lastmod>' . $product->updated_at->format('Y-m-d') . '</lastmod>';
            $xml .= '<changefreq>daily</changefreq>';
            $xml .= '<priority>0.9</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
