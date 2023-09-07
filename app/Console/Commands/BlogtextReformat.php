<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BlogtextReformat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:reformat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to reformat blog text to the new syntax. Use in conjunction with maintenance mode if required.';

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
        $entries = DB::table('blogentries')->get();
        $replace = ['<p>', '</p>', '<b>', '</b>', '<i>', '</i>'];
        $replaceWith = ['pg:', '', 'b[', ']', 'i[', ']'];
        foreach ($entries as $entry) {
            $newblogtext = str_replace($replace, $replaceWith, $entry->blogtext);
            DB::table('blogentries')->where('id', $entry->id)->update(['blogtext' => $newblogtext]);
        }
        return Command::SUCCESS;
    }
}
