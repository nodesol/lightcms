<?php

namespace Nodesol\Lightcms\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Nodesol\Lightcms\Models\Page;

class PageMakeCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:page
                            {name : Page Name}
                            {slug : Page Slug}
                            {--title="" : Page Title}
                            {--meta_keywords="" : Meta Keywords}
                            {--meta_description="" : Meta Description}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a page';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $page = Page::create([
            'name' => $this->argument('name'),
            'slug' => $this->argument('slug'),
            ...$this->options()
        ]);
        $this->comment("Page Created: ");
        $this->output($page);


        return self::SUCCESS;
    }
}
