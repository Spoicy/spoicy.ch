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
            Schema::create('blogentries', function ($table) {
                $table->increments('id');
                $table->integer('date');
                $table->text('blogtext');
            });
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
        $text = strip_tags(trim($request->request->get('blogTextarea')), '<b><i>');
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
        $text = strip_tags(trim($request->request->get('blogEditText'.$id)), '<b><i>');
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

    public static function view() {
        return view('pages/blog', [
            'entries' => self::getBlogEntries()
        ]);
    }
}
