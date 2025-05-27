<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // or just ['database'] if no email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Task Assigned')
            ->line("A new task has been assigned to you: {$this->task->name}")
            ->action('View Task', url('/tasks/' . $this->task->id))
            ->line('Thank you for using our app!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New task '{$this->task->name}' assigned to you.",
            'task_id' => $this->task->id,
        ];
    }
}
