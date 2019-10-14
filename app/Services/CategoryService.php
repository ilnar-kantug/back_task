<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Repositories\CategoryRepository;
use Illuminate\Support\Collection;

class CategoryService
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->getAllWithDepth();
    }

    public function create(CategoryRequest $request)
    {
        $category = $this->repository->create($request);
        return $category->freshWithDepth();
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $this->repository->update($request, $category);
        return $category->fresh();
    }

    public function delete(Category $category): ?bool
    {
        return $this->repository->delete($category);
    }
}
