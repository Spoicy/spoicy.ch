<?php

namespace App\Console\Commands;

use App\Helpers\BlogPostHelper;
use App\Models\BlogPost;
use Illuminate\Console\Command;

class AddUrlsToBlogPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:addurls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to be used to add URLs to the existing blog posts. Use in conjunction with maintenance mode if required.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (BlogPost::where('url', '')->get() as $post) {
            if (!isset($post->title) || $post->title == '') {
                echo "Blog post ID " . $post->id . " has no title, URL could not be generated.\n";
                continue;
            }
            $post->url = BlogPostHelper::createURL($post->title);
            $post->save();
        }
        return 0;
    }
}
