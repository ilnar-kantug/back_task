<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    const ATTR_NAME = 'name';
    const ATTR_SLUG = 'slug';
    const ATTR_PARENT_ID = 'parent_id';

    protected $fillable = [
        self::ATTR_NAME,
        self::ATTR_SLUG,
        self::ATTR_PARENT_ID,
    ];

    public function getRouteKeyName(): string
    {
        return self::ATTR_SLUG;
    }
}
