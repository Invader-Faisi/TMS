<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskDeadlineReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTaskDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-task-deadline-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send deadline reminder notifications to assigned members';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('status', '!=', 'Completed')
            ->whereDate('deadline', '=', Carbon::tomorrow())
            ->get();

        foreach ($tasks as $task) {
            if ($task->assigned_to) {
                $user = User::find($task->assigned_to);
                if ($user) {
                    $user->notify(new TaskDeadlineReminderNotification($task));
                }
            }
        }
        $this->info('Task deadline reminders sent successfully.');
    }
}
