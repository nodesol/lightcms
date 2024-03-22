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
                            {--title= : Page Title}
                            {--meta_keywords= : Meta Keywords}
                            {--meta_description= : Meta Description}
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
            'title' => $this->option('title'),
            'meta_keywords' => $this->option('meta_keywords'),
            'meta_description' => $this->option('meta_description'),
        ]);
        $this->comment('Page Created: ');
        $this->table(['name', 'slug', 'title', 'meta_description', 'meta_keywords'], [$page->only('name', 'slug', 'title', 'meta_description', 'meta_keywords')]);

        return self::SUCCESS;
    }
}
