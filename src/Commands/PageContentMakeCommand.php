<?php

namespace Nodesol\Lightcms\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Nodesol\Lightcms\Models\Page;
use Nodesol\Lightcms\Models\PageContent;

class PageContentMakeCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:page-content
                            {page : Page Name or ID}
                            {name : Content Name}
                            {--type=text : Content Type}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a page content';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $page = Page::query()
            ->whereName($this->argument('page'))
            ->orWhere('id', $this->argument('page'))
            ->first();
        if (! $page->id) {
            $this->error('Page Not Found');

            return self::FAILURE;
        }
        $content = PageContent::create([
            'page_id' => $page->id,
            'name' => $this->argument('name'),
            ...$this->options(),
        ]);
        $this->comment('Content Created: ');
        $this->table(['name', 'page_id', 'type'], [$content->only('name', 'page_id', 'type')]);

        return self::SUCCESS;
    }
}
