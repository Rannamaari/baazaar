<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        // Get featured categories
        $featuredCategories = Category::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('featured_rank')
            ->orderBy('name')
            ->get();

        // Get products for each featured category
        $categoryProducts = [];
        foreach ($featuredCategories as $category) {
            $categoryProducts[$category->id] = [
                'products' => Product::with(['category', 'images'])
                    ->where('category_id', $category->id)
                    ->where('is_active', true)
                    ->limit(8)
                    ->get()
            ];
        }

        return view('catalog.index', compact('featuredCategories', 'categoryProducts'));
    }

    public function categories(): View
    {
        // Cache all active categories for 30 minutes
        $categories = Cache::remember('all_active_categories', now()->addMinutes(30), function () {
            return Category::active()->orderBy('name')->get();
        });

        return view('catalog.categories', compact('categories'));
    }

    public function category(Request $request, string $slug): View
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Cache categories for 30 minutes
        $categories = Cache::remember('active_categories', now()->addMinutes(30), function () {
            return Category::active()->get();
        });

        // Get subcategories for this category
        $subcategories = $category->subcategories()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Build products query with filters
        $productsQuery = Product::with(['category', 'subcategory', 'images'])
            ->where('category_id', $category->id)
            ->where('is_active', true);

        // Apply search filter
        if ($request->filled('search')) {
            $productsQuery->where(function ($query) use ($request) {
                $query->where('name', 'ilike', "%{$request->search}%")
                    ->orWhere('description', 'ilike', "%{$request->search}%");
            });
        }

        // Apply subcategory filter
        if ($request->filled('subcategory')) {
            $productsQuery->where('subcategory_id', $request->subcategory);
        }

        // Apply price range filter
        if ($request->filled('min_price')) {
            $productsQuery->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $productsQuery->where('price', '<=', $request->max_price);
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low_high':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name_a_z':
                $productsQuery->orderBy('name', 'asc');
                break;
            case 'name_z_a':
                $productsQuery->orderBy('name', 'desc');
                break;
            case 'latest':
            default:
                $productsQuery->latest();
                break;
        }

        $products = $productsQuery->paginate(12);

        // Get view mode from request or default to grid
        $viewMode = $request->get('view', 'grid');

        return view('catalog.category', compact('category', 'categories', 'subcategories', 'products', 'viewMode'));
    }

    public function show(string $slug): View
    {
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}
