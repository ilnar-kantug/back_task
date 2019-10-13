<?php
declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductStoreTest extends TestCase
{
    public function testItCreatesProductAndStoresImage(): void
    {
        Storage::fake('public');

        $categoriesIds = factory(Category::class, 5)->create()->pluck(Category::PRIMARY_KEY);

        $response = $this->postJson(route('products.store'), [
            Product::ATTR_TITLE => $title = $this->faker->name,
            'photo' => $photo = UploadedFile::fake()->image('avatar.jpg'),
            'categories' => $categoriesIds
        ])
            ->assertSuccessful()
            ->assertJsonFragment([
                Product::ATTR_TITLE => $title
            ]);

        Storage::disk('public')->assertExists($this->getImagePath($response));
    }

    protected function getImagePath($response): string
    {
        $data = $response->json();
        $url = explode('http://localhost/storage/', $data['data']['image_url']);
        return $url[1];
    }
}
