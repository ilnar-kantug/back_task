<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testProductHasSlugAsRouteKeyName(): void
    {
        /** @var Product $category */
        $product = factory(Product::class)->create();

        $this->assertEquals($product->getRouteKey(), $product->slug);
    }

    public function testProductHasManyCategories(): void
    {
        /** @var Product $category */
        $product = factory(Product::class)->create();

        $categories = factory(Category::class, 2)->create();

        $product->categories()->attach($categories);

        $this->assertCount(2, $product->categories);
        $this->assertInstanceOf(Collection::class, $product->categories);
        $this->assertInstanceOf(Category::class, $product->categories->first());
    }
}
