<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\Blog;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $test = Blog::getBlogtextFormat('pg:This is a test a[string](google.com). b[Bold test string, i[Italic nested b[Bold nested string] string.] Test]');
        echo "$test";
        return 0;
    }
}
