<?php

namespace Nodesol\Lightcms\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $name
 * @property int $page_id
 * @property string $type
 * @property string $data
 * @property array $structure
 * @property mixed $value
 */
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
            case 'image':
                if ($data['path']) {
                    $value = Storage::disk(config('lightcms.storage_disk'))->url($data['path']);
                }
                break;
            default:
                $value = $data['value'] ?? null;
        }

        return Attribute::make(
            get: fn () => $value
        );
    }
}
