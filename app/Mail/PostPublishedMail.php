<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostPublishedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $website;

    public function __construct($post, $website)
    {
        $this->post = $post;
        $this->website = $website;
    }

    public function build()
    {
        return $this->subject('New Post Published: ' . $this->post->title)
                    ->view('emails.post-published')
                    ->with([
                        'postTitle' => $this->post->title,
                        'postDescription' => $this->post->description,
                        'websiteName' => $this->website->website_name,
                    ]);
    }
}
