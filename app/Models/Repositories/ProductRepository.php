<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseQueryRepository
{
    public function getModelName(): string
    {
        return Product::class;
    }

    public function createWithCategories(ProductRequest $request, string $imagePath)
    {
        return DB::transaction(function () use ($request, $imagePath) {
            $product = Product::create([
                Product::ATTR_TITLE => $request->get('title'),
                Product::ATTR_DESCRIPTION => $request->get('description'),
                Product::ATTR_IMAGE_PATH => $imagePath,
            ]);

            if ($request->has('categories')) {
                $product->categories()->attach($request->get('categories'));
            }
            return $product;
        });
    }

    public function updateWithCategories(ProductUpdateRequest $request, Product $product, string $imagePath): bool
    {
        return DB::transaction(function () use ($request, $product, $imagePath) {
            if ($request->has('categories')) {
                $product->categories()->detach();
                $product->categories()->attach($request->get('categories'));
            }

            return $product->update([
                Product::ATTR_TITLE => $request->get('title'),
                Product::ATTR_SLUG => $request->get('slug'),
                Product::ATTR_DESCRIPTION => $request->has('description')
                    ? $request->get('description')
                    : $product->description,
                Product::ATTR_IMAGE_PATH => $request->has('photo')
                    ? $imagePath
                    : $product->image_path,
            ]);
        });
    }
}
