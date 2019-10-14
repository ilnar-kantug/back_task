<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository extends BaseQueryRepository
{
    public function getModelName(): string
    {
        return Category::class;
    }

    public function getAllWithDepth(): Collection
    {
        return Category::defaultOrder()->withDepth()->get();
    }

    public function create(CategoryRequest $request)
    {
        return Category::create(
            $request->only([
                Category::ATTR_NAME,
                Category::ATTR_PARENT_ID
            ])
        );
    }

    public function update(CategoryUpdateRequest $request, Category $category): bool
    {
        return $category->update($request->only(['name', 'slug', 'parent_id']));
    }
}
