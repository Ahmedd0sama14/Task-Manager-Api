<?php

namespace App\Observers;

use App\Models\Task;
use App\Notifications\TaskNotification;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        $task->user->notify(new TaskNotification($task, 'created'));

    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->wasChanged('status') && $task->status === 'completed') {
            $task->user->notify(new TaskNotification($task, 'completed'));
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $task->user->notify(new TaskNotification($task, 'deleted'));
    }

    
}
