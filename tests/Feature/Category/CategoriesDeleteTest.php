<?php
declare(strict_types=1);

namespace Tests\Feature\Category;

use App\Models\Category;
use Tests\TestCase;

class CategoriesDeleteTest extends TestCase
{
    public function testItDeletesCategory(): void
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $this->delete(route('categories.update', ['category' => $category]))
            ->assertNoContent();

        $this->assertDatabaseMissing('categories', [
            Category::ATTR_NAME => $category->name,
            Category::ATTR_SLUG => $category->slug
        ]);
    }

    public function testItDeletesChildrenCategories()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $subcategory = factory(Category::class)->create();
        $category->appendNode($subcategory);

        $this->assertDatabaseHas('categories', [
            Category::ATTR_NAME => $subcategory->name,
            Category::ATTR_SLUG => $subcategory->slug
        ]);

        $this->delete(route('categories.update', ['category' => $category]))
            ->assertNoContent();

        $this->assertDatabaseMissing('categories', [
            Category::ATTR_NAME => $subcategory->name,
            Category::ATTR_SLUG => $subcategory->slug
        ]);
    }
}
