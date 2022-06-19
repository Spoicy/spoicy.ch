<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class Blog extends Controller
{
    /**
     * Retrieves all blog entries from the database.
     * 
     * @return Collection $entries
     */
    public static function getBlogEntries() {
        if (!Schema::hasTable('blogentries')) {
            return array();
        }
        $entries = DB::table('blogentries')->orderby('date', 'desc')->get();
        return $entries;
    }

    /**
     * Adds a new entry to the blog
     * 
     * @param Request $request
     */
    public static function addBlogEntry(Request $request) {
        $text = strip_tags(trim($request->request->get('blogTextarea')));
        $entriesTable = DB::table('blogentries');
        if (strlen($text)) {
            $entriesTable->insert([
                'date' => time(),
                'blogtext' => $text
            ]);
            return redirect('/blog')->with('status', 1);
        } else {
            return redirect('/blog')->with('status', 2);
        }
    }

    /**
     * Edit an existing blog entry
     * 
     * @param Request $request
     * @param int $id
     * @return bool $success
     */
    public static function editBlogEntry(Request $request, $id) {
        $text = strip_tags(trim($request->request->get('blogEditText'.$id)));
        $entriesTable = DB::table('blogentries');
        if (strlen($text)) {
            $entriesTable->where('id', $id)->update(['blogtext' => $text]);
            return redirect('/blog')->with('status', 3);
        } else {
            return redirect('/blog')->with('status', 4);
        }
    }

    /**
     * Formats the date to include the day suffix.
     * 
     * @param int $date
     * @return string
     */
    public static function getDateFormat($date) {
        $month = date('F', $date);
        $day = date('j', $date);
        $year = date('Y', $date);
        // Add day of the month suffix
        switch ($day) {
            case '1':
            case '21':
            case '31':
                $day = $day . 'st';
                break;
            case '2':
            case '22':
                $day = $day . 'nd';
                break;
            case '3':
            case '23':
                $day = $day . 'rd';
            default:
                $day = $day . 'th';
        }
        return "$month $day, $year";
    }

    /**
     * 
     */
    public static function getBlogtextFormat($text) {
        $modifiers = ['b' => 'normal', 'i' => 'normal', 'a' => 'link'];
        $pg = 'pg:';

        $textexplode = explode($pg, $text);
        if ($textexplode[0] == "") {
            array_shift($textexplode);
        }
        $newtext = "<p>";
        foreach ($textexplode as $item) {
            $newtext .= $item . '</p><p>';
        }
        $newtext = substr($newtext, 0, strlen($newtext) - 3);
        foreach ($modifiers as $modifier => $type) {
            if ($type == 'link') {
                $modStart = strpos($newtext, $modifier.'[');
                while ($modStart !== false) {
                    $modEnd = strpos($newtext, '](', $modStart + 1);
                    $linkStart = $modEnd + 2;
                    $linkEnd = strpos($newtext, ')', $linkStart);
                    $modText = substr($newtext, $modStart + 2, $modEnd - $modStart - 2);
                    $linkText = substr($newtext, $linkStart, $linkEnd - $linkStart);
                    $newtext = substr($newtext, 0, $modStart) . "<$modifier href=\"$linkText\" target=\"_blank\">$modText</$modifier>" . substr($newtext, $linkEnd + 1);
                    $modStart = strpos($newtext, $modifier.'[');
                }
            } else {
                $modStart = strpos($newtext, $modifier.'[');
                $modCheck = $modEnd = $modStart + 1;
                while ($modStart !== false) {
                    $modEnd = strpos($newtext, ']', $modEnd + 1);
                    /* Check for nested formats */
                    $modCheck = strpos($newtext, '[', $modCheck + 1);
                    if ($modCheck !== false && $modCheck < $modEnd) {
                        continue;
                    }
                    $modText = substr($newtext, $modStart + 2, $modEnd - $modStart - 2);
                    $newtext = substr($newtext, 0, $modStart) . "<$modifier>$modText</$modifier>" . substr($newtext, $modEnd + 1);
                    $modStart = strpos($newtext, $modifier.'[');
                    $modCheck = $modEnd = $modStart + 2;
                }
            }
        }
        return $newtext;
    }

    public static function view() {
        $entries = self::getBlogEntries();
        $temp = array();
        foreach ($entries as $entry) {
            $entry->rawtext = $entry->blogtext;
            $entry->blogtext = strip_tags($entry->blogtext);
            $temp[] = $entry;
        }
        return view('pages/blog', [
            'entries' => $entries
        ]);
    }
}
