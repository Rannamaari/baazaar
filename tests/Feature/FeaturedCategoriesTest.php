<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeaturedCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_featured_category(): void
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices and gadgets',
            'icon' => '📱',
            'is_featured' => true,
            'featured_rank' => 1,
            'is_active' => true,
        ]);

        $this->assertTrue($category->is_featured);
        $this->assertEquals(1, $category->featured_rank);
        $this->assertEquals('📱', $category->icon);
    }

    public function test_cannot_have_more_than_three_featured_categories(): void
    {
        // Create 3 featured categories
        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices',
            'icon' => '📱',
            'is_featured' => true,
            'featured_rank' => 1,
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Fashion items',
            'icon' => '👕',
            'is_featured' => true,
            'featured_rank' => 2,
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Home',
            'slug' => 'home',
            'description' => 'Home items',
            'icon' => '🏠',
            'is_featured' => true,
            'featured_rank' => 3,
            'is_active' => true,
        ]);

        // Try to create a 4th featured category with duplicate rank
        $this->expectException(\Illuminate\Database\QueryException::class);

        Category::create([
            'name' => 'Sports',
            'slug' => 'sports',
            'description' => 'Sports items',
            'icon' => '⚽',
            'is_featured' => true,
            'featured_rank' => 1, // This should fail due to unique constraint
            'is_active' => true,
        ]);
    }

    public function test_cannot_have_duplicate_featured_ranks(): void
    {
        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices',
            'icon' => '📱',
            'is_featured' => true,
            'featured_rank' => 1,
            'is_active' => true,
        ]);

        // Try to create another category with the same rank
        $this->expectException(\Illuminate\Database\QueryException::class);

        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Fashion items',
            'icon' => '👕',
            'is_featured' => true,
            'featured_rank' => 1, // This should fail due to unique constraint
            'is_active' => true,
        ]);
    }

    public function test_featured_categories_scope_works(): void
    {
        // Create featured and non-featured categories
        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices',
            'icon' => '📱',
            'is_featured' => true,
            'featured_rank' => 1,
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Fashion items',
            'icon' => '👕',
            'is_featured' => true,
            'featured_rank' => 2,
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Books',
            'slug' => 'books',
            'description' => 'Books',
            'icon' => '📚',
            'is_featured' => false,
            'featured_rank' => null,
            'is_active' => true,
        ]);

        $featuredCategories = Category::featured()->get();

        $this->assertCount(2, $featuredCategories);
        $this->assertTrue($featuredCategories->every(fn ($category) => $category->is_featured));
    }

    public function test_featured_categories_are_ordered_by_rank(): void
    {
        // Create featured categories in random order
        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Fashion items',
            'icon' => '👕',
            'is_featured' => true,
            'featured_rank' => 2,
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices',
            'icon' => '📱',
            'is_featured' => true,
            'featured_rank' => 1,
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Home',
            'slug' => 'home',
            'description' => 'Home items',
            'icon' => '🏠',
            'is_featured' => true,
            'featured_rank' => 3,
            'is_active' => true,
        ]);

        $featuredCategories = Category::featured()->get();

        $this->assertEquals('Electronics', $featuredCategories->first()->name);
        $this->assertEquals('Home', $featuredCategories->last()->name);
    }

    public function test_is_featured_rank_available_method(): void
    {
        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices',
            'icon' => '📱',
            'is_featured' => true,
            'featured_rank' => 1,
            'is_active' => true,
        ]);

        $this->assertFalse(Category::isFeaturedRankAvailable(1));
        $this->assertTrue(Category::isFeaturedRankAvailable(2));
        $this->assertTrue(Category::isFeaturedRankAvailable(3));
    }

    public function test_featured_categories_count(): void
    {
        $this->assertEquals(0, Category::getFeaturedCount());

        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices',
            'icon' => '📱',
            'is_featured' => true,
            'featured_rank' => 1,
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Fashion items',
            'icon' => '👕',
            'is_featured' => true,
            'featured_rank' => 2,
            'is_active' => true,
        ]);

        $this->assertEquals(2, Category::getFeaturedCount());
    }

    public function test_catalog_index_shows_featured_categories(): void
    {
        // Create featured categories
        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices',
            'icon' => '📱',
            'is_featured' => true,
            'featured_rank' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Featured Categories');
        $response->assertSee('Electronics');
    }
}
