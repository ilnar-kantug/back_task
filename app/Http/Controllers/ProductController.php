<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\Responder;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    use Responder;

    public function index()
    {
        return $this->respondJson(
            ProductResource::collection(Product::all())
        );
    }
}
