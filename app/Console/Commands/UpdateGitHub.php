<?php

namespace App\Console\Commands;

use App\Helpers\GithubEventHelper;
use App\Models\GithubEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class UpdateGitHub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the most recent GitHub actions';

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
        if (!Schema::hasTable('github_events')) {
            die("No table found, please run migrations first.");
        }

        $query = GithubEvent::all();
        $sids = array();
        foreach ($query as $result) {
            $sids[] = $result->sid;
        }

        $feed = simplexml_load_file("https://github.com/spoicy.atom");
        $i = count($feed->entry) - 1;
        try {
            for ($i = count($feed->entry) - 4; $i >= 0; $i--) {
                $eventProcess = "process" . explode("/", explode("tag:github.com,2008:", $feed->entry[$i]->id)[1])[0];
                $sid = explode("/", $feed->entry[$i]->id)[1];
                if (!in_array($sid, $sids) && method_exists(GithubEventHelper::class, $eventProcess)){
                    GithubEventHelper::$eventProcess($feed->entry[$i]);
                }
            }
        } catch (\Exception $e) {
            echo "Error with requesting Github API: " . $e->getMessage();
        }
        return Command::SUCCESS;
    }
}
