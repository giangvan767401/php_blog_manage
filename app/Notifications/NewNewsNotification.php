<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewNewsNotification extends Notification
{
    use Queueable;

    protected $news;

    public function __construct($news)
    {
        $this->news = $news;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'news_id' => $this->news->id,
            'title' => $this->news->title,
            'message' => 'Có bài viết mới: ' . $this->news->title,
            'url' => route('news.show', $this->news->id),
        ];
    }
}
