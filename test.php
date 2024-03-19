<?php
die(var_dump('grep -E -r -l -i ":author|:vendor|:package|Nodesol|lightcms|lightcms|vendor_name|vendor_slug|amer@nodesol.com" --exclude-dir=vendor ./* ./.github/* | grep -v '.basename(__FILE__)));

explode(PHP_EOL, trim((string) shell_exec('grep -E -r -l -i ":author|:vendor|:package|Nodesol|lightcms|lightcms|vendor_name|vendor_slug|amer@nodesol.com" --exclude-dir=vendor ./* ./.github/* | grep -v '.basename(__FILE__))));
