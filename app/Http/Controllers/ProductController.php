<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\Responder;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    use Responder;

    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->respondJson(
            ProductResource::collection(Product::all())
        );
    }

    public function show(Product $product)
    {
        return $this->respondJson(
            new ProductResource($product)
        );
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->respondEmpty();
    }

    public function store(ProductRequest $request)
    {
        $product = $this->service->create($request);

        return $this->respondJson(
            new ProductResource($product)
        );
    }
}
