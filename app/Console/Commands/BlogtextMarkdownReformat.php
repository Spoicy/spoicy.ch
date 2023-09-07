<?php

namespace App\Console\Commands;

use App\Helpers\BlogPostHelper;
use App\Models\BlogPost;
use Illuminate\Console\Command;

class BlogtextMarkdownReformat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:mdreformat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to reformat blog text from the old custom syntax to markdown. Use in conjunction with maintenance mode if required.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $posts = BlogPost::all();
        $replace = ['<p>', '</p>', '<b>', '</b>', '<i>', '</i>'];
        $replaceWith = ['', "\r\n", '**', '**', '*', '*'];
        foreach ($posts as $post) {
            $text = $post->blogtext;
            // Replace all links
            $text = str_replace('a[', '[', $text);
            // Reuse formatter to make formatting easier
            $text = BlogPostHelper::getBlogtextFormat($text);
            $text = str_replace($replace, $replaceWith, $text);
            $post->blogtext = $text;
            $post->save();
        }
        return Command::SUCCESS;
    }
}
