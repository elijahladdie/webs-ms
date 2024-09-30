<?php 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Website;
use App\Mail\PostPublishedMail; 
use Illuminate\Support\Facades\Mail; 
use App\Models\SentPost; 
use App\Models\Subscription;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'website_id' => 'required|exists:websites,website_id', // Use correct column for `exists`
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
          $post = null;
        // Create the post
        try {
          $post = Post::create([
                'website_id' => $request->website_id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            
            Log::info('Post created successfully', ['post_id' => $post->id]);
        } catch (\Exception $e) {
            Log::error('Failed to create post', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to create post'], 500);
        }

        // Retrieve subscriptions
        $subscriptions = Subscription::where('website_id', $post->website_id)->get();

        // Retrieve the website details
        $website = Website::find($post->website_id);
        if (!$website) {
            Log::error('Website not found', ['website_id' => $post->website_id]);
            return response()->json(['message' => 'Website not found'], 404);
        }

        // Check if there are any subscriptions
        if ($subscriptions->isEmpty()) {
            Log::warning('No subscriptions found for website', ['website_id' => $post->website_id]);
            return response()->json(['message' => 'No subscribers for this website'], 200);
        }

        // Process emails and sent_posts storage
        $emailCount = 0;
        foreach ($subscriptions as $subscription) {
            try {
                // Send email
                Mail::to($subscription->sub_email)->send(new PostPublishedMail($post, $website));
                Log::info('Email sent to subscriber', ['email' => $subscription->sub_email, 'post_id' => $post->id]);
                SentPost::create([
                    'post_id' => $post->id, 
                    'sub_id' => $subscription->sub_id,
                    'sent_at' => now(),
                ]);
                $emailCount++;
            } catch (\Exception $e) {
                Log::error('Failed to send email to subscriber', [
                    'email' => $subscription->sub_email,
                    'post_id' => $post->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        return response()->json([
            'message' => 'Post created and emails sent successfully',
            'post' => $post,
            'emails_sent' => $emailCount,
        ], 201);
    }
}
