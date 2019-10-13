<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected $uploaderService;

    public function __construct(PhotoService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

    public function create(ProductRequest $request): Product
    {
        $imagePath = $this->uploaderService->savePhoto($request);
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

    public function update(Product $product, ProductUpdateRequest $request): bool
    {
        $imagePath = '';
        if ($request->has('photo')) {
            $imagePath = $this->uploaderService->savePhoto($request);
        }

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
