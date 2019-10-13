<?php
declare(strict_types=1);

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $categories->each(function (Category $category) {
            $products = factory(Product::class, rand(1, 5))->create();
            $category->products()->attach($products->pluck('id'));
        });
    }
}
