<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\Responder;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

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
}
