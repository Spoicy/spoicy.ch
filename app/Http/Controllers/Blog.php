<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Blog extends Controller
{
    /**
     * Retrieves all blog entries from the database.
     * 
     * @return array $entries
     */
    public static function getBlogEntries() {
        $entries = array();

        return $entries;
    }

    /**
     * Adds a new entry to the blog
     * 
     * @param Request $request
     */
    public static function addBlogEntry(Request $request) {
        $text = $request->request->get('blogTextarea');
        return redirect('/blog')->with('status', 1);
    }

    /**
     * Edit an existing blog entry
     * 
     * @param int $id
     * @return bool $success
     */
    public static function editBlogEntry($id) {

    }

    public static function view() {
        return view('pages/blog', [
            'entries' => self::getBlogEntries()
        ]);
    }
}
