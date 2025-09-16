<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->get('q', '');
        $categorySlug = $request->get('category');
        $perPage = 12;

        $results = collect();
        $totalResults = 0;

        if (strlen($query) >= 2) {
            $cacheKey = 'search:' . md5($query . $categorySlug . $perPage . $request->get('page', 1));
            
            $searchResults = Cache::remember($cacheKey, now()->addMinutes(15), function () use ($query, $categorySlug, $perPage) {
                return $this->performSearch($query, $categorySlug, $perPage);
            });

            $results = $searchResults['results'];
            $totalResults = $searchResults['total'];
        }

        $categories = Cache::remember('search_categories', now()->addHour(), function () {
            return Category::active()->orderBy('name')->get();
        });

        return view('search.index', compact('query', 'results', 'totalResults', 'categories', 'categorySlug'));
    }

    private function performSearch(string $query, ?string $categorySlug, int $perPage): array
    {
        $searchTerms = explode(' ', trim($query));
        
        $productsQuery = Product::with(['category', 'images'])
            ->where('is_active', true)
            ->where(function (Builder $queryBuilder) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $queryBuilder->where(function (Builder $subQuery) use ($term) {
                        $subQuery->where('name', 'ilike', "%{$term}%")
                            ->orWhere('description', 'ilike', "%{$term}%");
                    });
                }
            });

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->where('is_active', true)->first();
            if ($category) {
                $productsQuery->where('category_id', $category->id);
            }
        }

        // Order by relevance: exact matches first, then partial matches
        $productsQuery->orderByRaw("
            CASE 
                WHEN LOWER(name) = LOWER(?) THEN 1
                WHEN LOWER(name) LIKE LOWER(?) THEN 2
                WHEN LOWER(description) LIKE LOWER(?) THEN 3
                ELSE 4
            END
        ", [$query, "%{$query}%", "%{$query}%"])
        ->orderBy('created_at', 'desc');

        $results = $productsQuery->paginate($perPage);

        return [
            'results' => $results,
            'total' => $results->total(),
        ];
    }

    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $cacheKey = 'search_suggestions:' . md5($query);
        
        $suggestions = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($query) {
            $products = Product::select(['name', 'slug'])
                ->where('is_active', true)
                ->where('name', 'ilike', "%{$query}%")
                ->orderBy('name')
                ->limit(8)
                ->get()
                ->map(function ($product) {
                    return [
                        'type' => 'product',
                        'name' => $product->name,
                        'url' => route('product.show', $product->slug),
                    ];
                });

            $categories = Category::select(['name', 'slug'])
                ->where('is_active', true)
                ->where('name', 'ilike', "%{$query}%")
                ->orderBy('name')
                ->limit(5)
                ->get()
                ->map(function ($category) {
                    return [
                        'type' => 'category',
                        'name' => $category->name,
                        'url' => route('category.show', $category->slug),
                    ];
                });

            return $products->concat($categories)->take(10);
        });

        return response()->json($suggestions);
    }
}