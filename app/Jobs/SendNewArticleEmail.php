<?php

namespace App\Jobs;
use App\Models\Subscriber;

use App\Mail\NewArticleNotification;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewArticleEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $article;

    /**
     * Create a new job instance.
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Danh sách email cần nhận
        $recipients = Subscriber::pluck('email')->toArray();

        foreach ($recipients as $email) {
            Mail::to($email)->send(new NewArticleNotification($this->article));
        }
    }
}
