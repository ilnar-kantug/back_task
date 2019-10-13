<?php
declare(strict_types=1);

namespace Tests\Feature\Category;

use App\Models\Category;
use Tests\TestCase;

class CategoriesIndexTest extends TestCase
{
    public function testReturnsCategoriesCollection(): void
    {
        $categories = factory(Category::class, 10)->create();
        /** @var Category $category */
        $category = $categories->first();

        $this->getJson(route('categories.index'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                        'depth',
                    ]
                ]
            ])
            ->assertJsonFragment([
                [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'depth' => 0,
                ]
            ]);
    }
}
