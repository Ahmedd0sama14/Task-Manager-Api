<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    private function manage(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }
    public function view(User $user, Task $task)
    {
        return $this->manage($user, $task);
    }
    public function update(User $user, Task $task)
    {
        return !$task->completed && $this->manage($user, $task);
    } public function delete(User $user, Task $task)
    {
        return $this->manage($user, $task);
    }
}
