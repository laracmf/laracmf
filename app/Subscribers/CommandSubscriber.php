<?php

namespace App\Subscribers;

use App\Repositories\PageRepository;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;

class CommandSubscriber
{
    /**
     * The page repository instance.
     *
     * @var \App\Repositories\PageRepository
     */
    protected $pageRepository;

    /**
     * Create a new instance.
     *
     * @param \App\Repositories\PageRepository $pageRepository
     *
     * @return void
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     *
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'command.updatecache',
            'App\Subscribers\CommandSubscriber@onUpdateCache',
            3
        );
    }

    /**
     * Handle a command.updatecache event.
     *
     * @param \Illuminate\Console\Command $command
     *
     * @return void
     */
    public function onUpdateCache(Command $command)
    {
        $command->line('Regenerating page cache...');
        $this->pageRepository->refresh();
        $command->info('Page cache regenerated!');
    }

    /**
     * Get the page repository instance.
     *
     * @return \App\Repositories\PageRepository
     */
    public function getPageRepository()
    {
        return $this->pageRepository;
    }
}
