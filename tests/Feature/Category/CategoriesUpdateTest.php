<?php
declare(strict_types=1);

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoriesUpdateTest extends TestCase
{
    public function testItUpdatesCategory(): void
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $this->patchJson(route('categories.update', ['category' => $category]), [
            Category::ATTR_NAME => $newName = 'New name',
            Category::ATTR_SLUG => $newSlug = 'New-slug',
        ])
            ->assertSuccessful()
            ->assertJsonFragment([
                Category::ATTR_NAME => $newName,
                Category::ATTR_SLUG => $newSlug,
            ]);

        $this->assertDatabaseHas('categories', [
            Category::ATTR_NAME => $newName,
            Category::ATTR_SLUG => $newSlug
        ]);
    }

    public function testItCanNotUpdateCategoryWithExistingSlug(): void
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        /** @var Category $category */
        $otherCategory = factory(Category::class)->create();

        $this->patchJson(route('categories.update', ['category' => $category]), [
            Category::ATTR_NAME => 'New name',
            Category::ATTR_SLUG => $otherCategory->slug,
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('slug');
    }

    public function testItCanUpdateCategoryWithItsSlug(): void
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $this->patchJson(route('categories.update', ['category' => $category]), [
            Category::ATTR_NAME => $newName = 'New name',
            Category::ATTR_SLUG => $category->slug,
        ])
            ->assertSuccessful()
            ->assertJsonFragment([
                Category::ATTR_NAME => $newName,
                Category::ATTR_SLUG => $category->slug,
            ]);

        $this->assertDatabaseHas('categories', [
            Category::ATTR_NAME => $newName,
            Category::ATTR_SLUG => $category->slug
        ]);
    }
}
