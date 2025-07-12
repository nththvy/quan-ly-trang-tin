<?php

namespace App\Mail;

use App\Models\Article;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewArticleNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $article;
    public $url;

    public function __construct(Article $article)
    {
        $this->article = $article;

        $this->url = route('frontend.article.show', [
            'category_slug' => $article->category->slug,
            'article_slug' => $article->title_slug, // assuming 'title_slug' is article_slug
        ]);
    }

    public function build()
    {
        return $this->subject('Có bài viết mới trên website')
            ->view('email.new_article')
            ->with([
                'article' => $this->article,
                'url' => $this->url,
            ]);
    }
}
