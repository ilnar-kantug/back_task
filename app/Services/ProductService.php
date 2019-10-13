<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

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

        return Product::create([
            Product::ATTR_TITLE => $request->get('title'),
            Product::ATTR_DESCRIPTION => $request->get('description'),
            Product::ATTR_IMAGE_PATH => $imagePath,
        ]);
    }
}
