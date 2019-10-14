<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\Responder;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryIndexResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    use Responder;

    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->respondJson(
            CategoryIndexResource::collection(
                $this->service->getAll()
            )
        );
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->service->create($request);

        return $this->respondJson(
            new CategoryResource($category),
            Response::HTTP_CREATED
        );
    }

    public function show(Category $category)
    {
        return $this->respondJson(
            new CategoryResource($category)
        );
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category = $this->service->update($request, $category);

        return $this->respondJson(
            new CategoryResource($category)
        );
    }

    public function destroy(Category $category)
    {
        $this->service->delete($category);
        return $this->respondEmpty();
    }

    public function products(Category $category)
    {
        return $this->respondJson(
            ProductResource::collection($category->products)
        );
    }
}
