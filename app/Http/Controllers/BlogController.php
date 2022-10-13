<?php

namespace App\Http\Controllers;

use App\Helpers\BlogPostHelper;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Adds a new entry to the blog
     * 
     * @param Request $request
     * @return void $redirect
     */
    public static function add(Request $request) {
        $text = strip_tags(trim($request->request->get('blogTextarea')));
        $title = strip_tags(trim($request->request->get('blogEditTitle')));
        if (strlen($text) && BlogPostHelper::validateBlogAction()) {
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
    public static function edit(Request $request, int $id) {
        $text = strip_tags(trim($request->request->get('blogEditText'.$id)));
        $title = strip_tags(trim($request->request->get('blogEditTitle'.$id)));
        if (strlen($text) && BlogPostHelper::validateBlogAction()) {
            BlogPost::where('id', $id)->update(['blogtext' => $text, 'title' => $title]);
            return redirect('/blog')->with('status', 3);
        }
        return redirect('/blog')->with('status', 4);
    }

    /**
     * Returns the view for all blog posts
     * 
     * @return View $page
     */
    public static function view(): \Illuminate\Contracts\View\View {
        $posts = BlogPost::orderby('date', 'desc')->get();
        foreach ($posts as $post) {
            $post->rawtext = $post->blogtext;
            $post->blogtext = BlogPostHelper::getBlogtextFormat(strip_tags($post->blogtext));
            $post->date = BlogPostHelper::getDateFormat($post->date);
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
    public static function viewPost($id): \Illuminate\Contracts\View\View {
        if (!is_numeric($id)) {
            abort(404);
        }
        $post = BlogPost::find($id);
        if (!$post) {
            abort(404);
        }
        $post->rawtext = $post->blogtext;
        $post->blogtext = BlogPostHelper::getBlogtextFormat(strip_tags($post->blogtext));
        $post->date = BlogPostHelper::getDateFormat($post->date);
        return view('pages/blogpost', [
            'post' => $post
        ]);
    }
}
