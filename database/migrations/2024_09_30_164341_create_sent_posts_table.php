<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sent_posts', function (Blueprint $table) {
            $table->id(); // primary key
            $table->foreignId('post_id')->constrained('posts', 'post_id')->onDelete('cascade'); 
            $table->foreignId('sub_id')->constrained('subscriptions', 'sub_id')->onDelete('cascade');
            $table->timestamp('sent_at')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_posts');
    }
};
