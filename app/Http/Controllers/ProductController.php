<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\Responder;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Response;

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
            new ProductResource($product->fresh('categories'))
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

    public function update(Product $product, ProductUpdateRequest $request)
    {
        abort_unless(
            $this->service->update($product, $request),
            Response::HTTP_BAD_REQUEST,
            'Cant update the product, try later'
        );

        return $this->respondJson(
            new ProductResource($product->fresh())
        );
    }
}
