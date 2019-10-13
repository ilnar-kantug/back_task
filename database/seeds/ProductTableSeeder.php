<?php
declare(strict_types=1);

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Collection $categories */
        $categories = Category::all();
        $products = factory(Product::class, rand(50, 100))->create();
        $products->each(function (Product $product) use ($categories) {
            $product->categories()->attach($categories->random(rand(2, 5)));
        });
    }
}
