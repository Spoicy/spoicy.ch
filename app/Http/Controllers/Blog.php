<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Blog extends Controller
{
    /**
     * Validates a blog action
     * 
     * @return bool
     */
    public static function validateBlogAction(): bool {
        if (session('loggedin') && Hash::check(session('loggedin'), env("BLOG_PASS"))) {
            return true;
        }
        return false;
    }

    /**
     * Adds a new entry to the blog
     * 
     * @param Request $request
     * @return void $redirect
     */
    public static function addBlogEntry(Request $request) {
        $text = strip_tags(trim($request->request->get('blogTextarea')));
        $title = strip_tags(trim($request->request->get('blogEditTitle')));
        if (strlen($text) && self::validateBlogAction()) {
            $newBlogPost = BlogPost::create([
                'date' => time(),
                'blogtext' => $text,
                'title' => $title
            ]);
            return redirect('/blog')->with('status', 1);
        }
        return redirect('/blog')->with('status', 2);
    }

    /**
     * Edit an existing blog entry
     * 
     * @param Request $request
     * @param int $id
     * @return void $success
     */
    public static function editBlogEntry(Request $request, int $id) {
        $text = strip_tags(trim($request->request->get('blogEditText'.$id)));
        $title = strip_tags(trim($request->request->get('blogEditTitle'.$id)));
        if (strlen($text) && self::validateBlogAction()) {
            BlogPost::where('id', $id)->update(['blogtext' => $text, 'title' => $title]);
            return redirect('/blog')->with('status', 3);
        }
        return redirect('/blog')->with('status', 4);
    }

    /**
     * Formats the date to include the day suffix.
     * 
     * @param int $date
     * @return string
     */
    public static function getDateFormat(int $date): string {
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
     * Format the blog post's text into HTML to be displayed.
     * 
     * @param string $text
     * @return string $newtext
     */
    public static function getBlogtextFormat(string $text): string {
        $modifiers = ['b' => 'normal', 'i' => 'normal', 'a' => 'link'];
        $pg = 'pg:';

        $textParagraphs = explode($pg, $text);
        if ($textParagraphs[0] == "") {
            array_shift($textParagraphs);
        }
        $newtext = "<p>";
        foreach ($textParagraphs as $item) {
            $newtext .= $item . '</p><p>';
        }
        $newtext = substr($newtext, 0, strlen($newtext) - 3);
        /* Apply modifiers to the semi-formatted text */
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

    /**
     * Returns the view for all blog posts
     * 
     * @return View $page
     */
    public static function view(): \Illuminate\Contracts\View\View {
        $posts = BlogPost::orderby('date', 'desc')->get();
        $temp = array();
        foreach ($posts as $post) {
            $post->rawtext = $post->blogtext;
            $post->blogtext = strip_tags($post->blogtext);
            $temp[] = $post;
        }
        return view('pages/blog', [
            'posts' => $posts
        ]);
    }

    /**
     * Returns the view for an individual blog post
     * 
     * @param int $id
     * @return View $page
     */
    public static function viewPost(int $id): \Illuminate\Contracts\View\View {
        $post = BlogPost::find($id);
        $post->rawtext = $post->blogtext;
        $post->blogtext = strip_tags($post->blogtext);
        return view('pages/blogpost', [
            'post' => $post
        ]);
    }
}
