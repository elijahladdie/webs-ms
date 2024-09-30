<?php

namespace App\Console\Commands;
use App\Models\Website; // Import the Website model
use App\Models\Post; // Import the Post model
use App\Models\Subscription; // Import the Subscription model
use Illuminate\Console\Command;

class SendPostEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:post-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $websites = Website::all();

        foreach ($websites as $website) {
            $unsentPosts = Post::where('website_id', $website->id)
                ->whereDoesntHave('sentPosts') 
                ->get();

            foreach ($unsentPosts as $post) {
                $subscribers = Subscription::where('website_id', $website->id)->get();

                foreach ($subscribers as $subscriber) {

                    Mail::to($subscriber->sub_email)->send(new PostPublishedMail($post));
                    SentPost::create([
                        'post_id' => $post->post_id, 
                        'sub_id' => $subscriber->id,
                        'sent_at' => now(),
                    ]);
                }
            }
        }

        $this->info('Emails sent successfully.');
    }
}
