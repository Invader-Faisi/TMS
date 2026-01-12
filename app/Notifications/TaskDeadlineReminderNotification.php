<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineReminderNotification extends Notification
{
    use Queueable;
    public Task $task;
    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'title' => 'Task Deadline Reminder',
            'message' => 'Your task "' . $this->task->title . '" is due soon.',
            'deadline' => $this->task->deadline,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task Deadline Reminder')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('This is a reminder that your task deadline is approaching.')
            ->line('Task: ' . $this->task->title)
            ->line('Deadline: ' . $this->task->deadline)
            ->action('View Task', route('tasks.show', $this->task->id))
            ->line('Please ensure timely completion.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
