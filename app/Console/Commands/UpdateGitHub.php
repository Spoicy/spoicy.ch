<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\GitHub;
use Illuminate\Support\Facades\Http;

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
        if (!Schema::hasTable('github')) {
            die("No table found, please run migrations first.");
        }
        $tableGithub = DB::table('github');

        $query = $tableGithub->get('sid');
        $sids = array();
        foreach ($query as $result) {
            $sids[] = $result->sid;
        }

        $feed = simplexml_load_file("https://github.com/spoicy.atom");
        $i = count($feed->entry) - 1;
        try {
            for ($i = count($feed->entry) - 1; $i >= 0; $i--) {
                $eventtype = explode("/", explode("tag:github.com,2008:", $feed->entry[$i]->id)[1])[0];
                $sid = explode("/", $feed->entry[$i]->id)[1];
                if (!in_array($sid, $sids)){
                    $entry = null;
                    switch ($eventtype) {
                        case "PushEvent":
                            $entry = GitHub::processPush($feed->entry[$i]);
                            break;
                        case "IssuesEvent":
                            $entry = GitHub::processIssue($feed->entry[$i]);
                            break;
                        case "WatchEvent":
                            $entry = GitHub::processWatch($feed->entry[$i]);
                            break;
                        default:
                            continue 2;
                    }
                    if ($entry) {
                        $tableGithub->insert([
                            'sid' => $sid,
                            'title' => $entry->title,
                            'link' => $entry->link,
                            'author' => $entry->author,
                            'date' => $entry->datetime,
                            'type' => $entry->type,
                            'entrydata' => json_encode($entry->entrydata)
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            echo "Max API calls was reached.";
        }
        return 0;
    }
}
