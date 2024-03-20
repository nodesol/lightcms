<?php

namespace Nodesol\Lightcms\ViewComposers;

use Illuminate\Contracts\View\View;
use Nodesol\Lightcms\Models\Page;

class Lightcms
{
    public function compose(View $view)
    {
        $data = $view->getData();
        if (isset($data['page'])) {
            if($data['page'] instanceof Page) {
                $page = $data['page'];
            } else {
                $page = Page::query()
                ->whereName($data['page'])
                ->orWhere('id', $data['page'])
                ->orWhere('slug', $data['page'])
                ->first();
            }

            if ($page->id) {
                $view->with('contents', $page->data);
            }
        }
    }
}
