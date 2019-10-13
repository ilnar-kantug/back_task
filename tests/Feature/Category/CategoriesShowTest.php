<?php
declare(strict_types=1);

namespace Tests\Feature\Category;

use App\Models\Category;
use Tests\TestCase;

class CategoriesShowTest extends TestCase
{
    public function testShowCategory(): void
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $this->getJson(route('categories.show', ['category' => $category]))
            ->assertSuccessful()
            ->assertJsonFragment([
                Category::PRIMARY_KEY => $category->getKey(),
                Category::ATTR_NAME => $category->name,
                Category::ATTR_SLUG => $category->slug,
            ]);
    }
}
