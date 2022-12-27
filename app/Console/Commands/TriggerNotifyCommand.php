<?php

namespace App\Console\Commands;

use App\Jobs\DispatchNotifyJob;
use App\Models\Task;
use App\Repositories\Task\TaskRepository;
use Illuminate\Console\Command;

class TriggerNotifyCommand extends Command
{
    public function __construct(protected TaskRepository $taskRepository)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'triggers notify job';

    public function handle()
    {
        $this->taskRepository->getAll()->map(function (Task $task) {
            DispatchNotifyJob::dispatch($task);
        });
    }
}
