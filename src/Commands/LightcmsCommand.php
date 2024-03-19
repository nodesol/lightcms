<?php

namespace Nodesol\Lightcms\Commands;

use Illuminate\Console\Command;

class LightcmsCommand extends Command
{
    public $signature = 'lightcms';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
