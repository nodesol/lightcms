<?php

namespace Nodesol\Lightcms\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'page_id', 'type', 'data'];

    public function structure(): Attribute
    {
        $data = json_decode($this->data, true);

        return Attribute::make(
            get: fn () => $data['structure'] ?? []
        );
    }

    public function value(): Attribute
    {
        $value = '';
        $data = json_decode($this->data, true);
        switch ($this->type) {
            case 'list':
                $value = $data;
                break;
            case 'objects':
                $value = $data['items'] ?? [];
                break;
            default:
                $value = $data['value'] ?? null;
        }

        return Attribute::make(
            get: fn () => $value
        );
    }
}
