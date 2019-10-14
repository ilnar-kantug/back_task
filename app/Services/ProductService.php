<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Repositories\ProductRepository;
use Illuminate\Support\Collection;

class ProductService
{
    protected $uploaderService;
    protected $repository;

    public function __construct(
        PhotoService $uploaderService,
        ProductRepository $repository
    ) {
        $this->uploaderService = $uploaderService;
        $this->repository = $repository;
    }

    public function create(ProductRequest $request): Product
    {
        $imagePath = $this->uploaderService->savePhoto($request);
        return $this->repository->createWithCategories($request, $imagePath);
    }

    public function update(Product $product, ProductUpdateRequest $request): bool
    {
        $imagePath = '';
        if ($request->has('photo')) {
            $imagePath = $this->uploaderService->savePhoto($request);
        }

        return $this->repository->updateWithCategories($request, $product, $imagePath);
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function delete(Product $product): ?bool
    {
        return $this->repository->delete($product);
    }
}
