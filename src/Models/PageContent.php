<?php

namespace Nodesol\Lightcms\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = ['name', 'page_id', 'type', 'data'];
    use HasFactory;

    function value():Attribute {
        $value = "";
        switch($this->type) {
            default:
                $value = $this->data['value'];
        }

        return Attribute::make(
            get: fn() => $value
        );
    }
}
