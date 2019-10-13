<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testCategoryHasNestedSets(): void
    {
        $category = factory(Category::class)->create();
        $numberOfDescendants = 2;
        $subcategories = factory(Category::class, $numberOfDescendants)->create();
        $subcategories->each(function ($subcategory) use ($category) {
            $category->appendNode($subcategory);
        });

        $category = $category->fresh('descendants');
        $this->assertCount($numberOfDescendants, $category->descendants);
        $this->assertInstanceOf(Collection::class, $category->descendants);
        $this->assertInstanceOf(Category::class, $category->descendants->first());

        $subcategorySiblings = $subcategories->first()->getSiblings();
        $this->assertCount(1, $subcategorySiblings);
    }

    public function testCategoryHasSlugAsRouteKeyName(): void
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $this->assertEquals($category->getRouteKey(), $category->slug);
    }

    public function testCategoryHasManyProducts(): void
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $products = factory(Product::class, 2)->create();

        $category->products()->attach($products);

        $this->assertCount(2, $category->products);
        $this->assertInstanceOf(Collection::class, $category->products);
        $this->assertInstanceOf(Product::class, $category->products->first());
    }
}
