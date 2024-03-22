<?php

namespace Nodesol\Lightcms\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property array $data
 * @property Collection $contents
 */
class Page extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'title', 'meta_description', 'meta_keywords'];

    public function contents(): HasMany
    {
        return $this->hasMany(PageContent::class);
    }

    public function data(): Attribute
    {
        $contents = $this->contents;
        $data = [];
        foreach ($contents as $content) {
            $data[$content->name] = $content->value;
        }

        return Attribute::make(
            get: fn () => $data,
        );
    }
}
