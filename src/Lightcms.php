<?php

namespace Nodesol\Lightcms;

use Nodesol\Lightcms\Models\Page;

class Lightcms
{
    public function view(?string $view = null, array $data = [])
    {
        if(isset($data['page'])) {
            $page = Page::query()
            ->whereName($data['page'])
            ->orWhere('id', $data['page'])
            ->first();
            $data['contents'] = $page->data;

            return view($view, $data);
        }
    }
}
