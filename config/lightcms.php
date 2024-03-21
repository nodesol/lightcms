<?php

// config for Nodesol/Lightcms
return [
    'storage_disk' => config('filesystems.default'),
    'guard' => 'lightcms',
    'image_path' => 'lightcms',
    'admin_url_prefix' => 'lightcms/admin',
    'pages_url_prefix' => 'lightcms/pages',
    'views_prefix' => 'lightcms.pages',
    'colors' => ['#6EBE43', '#1388D6'],
    'credits' => true,
];
