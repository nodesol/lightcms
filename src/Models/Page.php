<?php

namespace Nodesol\Lightcms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model {
    use HasFactory;

    public function components():HasMany {
        return $this->hasMany(PageContent::class);
    }
}
