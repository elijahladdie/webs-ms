<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SentPost;
class SentPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SentPost::create([
            'post_id' => 1, 
            'sub_id' => 1,  
            'sent_at' => now()
        ]);
    }
}
