<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $parent_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property integer $depth
 */
class Category extends Model
{
    use NodeTrait;

    const PRIMARY_KEY = 'id';
    const ATTR_NAME = 'name';
    const ATTR_SLUG = 'slug';
    const ATTR_PARENT_ID = 'parent_id';
    const ATTR_CREATED_AT = 'created_at';
    const ATTR_UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::ATTR_NAME,
        self::ATTR_SLUG,
        self::ATTR_PARENT_ID,
    ];

    protected $casts = [
        self::ATTR_CREATED_AT => 'datetime',
        self::ATTR_UPDATED_AT => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Category $category) {
            $category->slug = sprintf('%s-%s', Str::slug($category->name), Str::random(6));
        });
    }

    public function getRouteKeyName(): string
    {
        return self::ATTR_SLUG;
    }

    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
