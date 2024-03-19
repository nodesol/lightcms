<?php

namespace Nodesol\Lightcms\ViewComposers;

use Illuminate\Contracts\View\View;
use Nodesol\Lightcms\Models\Page;

class LightCms {
    public function compose(View $view) {
        $data = $view->getData();
        if(isset($data['page'])) {
            $page = Page::query()
            ->whereName($data['page'])
            ->orWhere('id', $data['page'])
            ->first();

            if($page->id) {
                $view->with('contents', $page->data);
            }
        }
    }
}
