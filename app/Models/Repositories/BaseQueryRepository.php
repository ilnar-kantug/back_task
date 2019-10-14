<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseQueryRepository
{
    abstract public function getModelName(): string;

    public function getQuery(): Builder
    {
        return $this->getModelName()::query();
    }

    public function all(): Collection
    {
        return $this->getQuery()->get();
    }

    public function find($id): Model
    {
        return $this->getQuery()->find($id);
    }

    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }
}
