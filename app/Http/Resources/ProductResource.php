<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Product $this */
        return [
            'id' => $this->getKey(),
            'name' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->imageUrl,
        ];
    }
}
