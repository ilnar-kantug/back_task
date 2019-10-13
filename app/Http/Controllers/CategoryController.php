<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\Responder;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    use Responder;

    public function index()
    {
        return $this->respondJson(
            CategoryResource::collection(
                Category::defaultOrder()->withDepth()->get()
            )
        );
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create(
            $request->only([
                Category::ATTR_NAME,
                Category::ATTR_PARENT_ID
            ])
        );

        return $this->respondJson(new CategoryResource($category), Response::HTTP_CREATED);
    }
}
