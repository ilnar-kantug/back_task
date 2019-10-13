<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    const ATTR_TITLE = 'title';
    const ATTR_SLUG = 'slug';
    const ATTR_DESCRIPTION = 'description';
    const ATTR_IMAGE_URL = 'image_url';

    public function getRouteKeyName(): string
    {
        return self::ATTR_SLUG;
    }

    public function categories(): belongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
