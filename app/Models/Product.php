<?php
declare(strict_types=1);

namespace App\Models;

use App\Services\PhotoService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $image_path
 * @property string $imageUrl
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Product extends Model
{
    const PRIMARY_KEY = 'id';
    const ATTR_TITLE = 'title';
    const ATTR_SLUG = 'slug';
    const ATTR_DESCRIPTION = 'description';
    const ATTR_IMAGE_PATH = 'image_path';
    const ATTR_CREATED_AT = 'created_at';
    const ATTR_UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::ATTR_TITLE,
        self::ATTR_SLUG,
        self::ATTR_DESCRIPTION,
        self::ATTR_IMAGE_PATH,
    ];

    protected $casts = [
        self::ATTR_CREATED_AT => 'datetime',
        self::ATTR_UPDATED_AT => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Product $product) {
            $product->slug = sprintf('%s-%s', Str::slug($product->title), Str::random(6));
        });
    }

    public function getImageUrlAttribute(): string
    {
        return strstr($this->image_path, 'http')
            ? $this->image_path
            : url(Storage::url(PhotoService::PRODUCT_IMAGES_FOLDER . $this->image_path));
    }

    public function getRouteKeyName(): string
    {
        return self::ATTR_SLUG;
    }

    public function categories(): belongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getFreshWithCategories(): self
    {
        return $this->fresh('categories');
    }
}
