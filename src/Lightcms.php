<?php

namespace Nodesol\Lightcms;

class Lightcms
{
    public function view(?string $view = null, array $data = [])
    {
        $page = $data['page'];

        return view($view, $data);
    }
}
