<?php
declare(strict_types=1);

namespace Tests\Feature\Category;

use App\Models\Category;
use Tests\TestCase;

class CategoriesStoreTest extends TestCase
{
    public function testCreatesAndReturnCategory(): void
    {
        $categoryProto = [
            Category::ATTR_NAME => $this->faker->name
        ];

        $response = $this->postJson(route('categories.store'), $categoryProto)
            ->assertSuccessful()
            ->assertJsonFragment([
                $categoryProto[Category::ATTR_NAME]
            ]);

        $this->assertDatabaseHas('categories', [
            Category::PRIMARY_KEY => $response->json('data.id'),
            Category::ATTR_NAME => $categoryProto[Category::ATTR_NAME]
        ]);
    }
}
