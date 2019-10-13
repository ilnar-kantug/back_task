<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $image_url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Product extends Model
{
    const ATTR_TITLE = 'title';
    const ATTR_SLUG = 'slug';
    const ATTR_DESCRIPTION = 'description';
    const ATTR_IMAGE_URL = 'image_url';
    const ATTR_CREATED_AT = 'created_at';
    const ATTR_UPDATED_AT = 'updated_at';

    protected $casts = [
        self::ATTR_CREATED_AT => 'datetime',
        self::ATTR_UPDATED_AT => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return self::ATTR_SLUG;
    }

    public function categories(): belongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
