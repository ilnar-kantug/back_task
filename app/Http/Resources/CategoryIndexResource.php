<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Category;

class CategoryIndexResource extends CategoryResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Category $this */
        return array_merge(parent::toArray($request), [
            'depth' => $this->depth
        ]);
    }
}
