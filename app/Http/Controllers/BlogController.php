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
        $title = strip_tags(trim($request->request->get('blogTitle')));
        if (strlen($text) && BlogPostHelper::validateBlogAction()) {
            BlogPost::create([
                'date' => time(),
                'blogtext' => $text,
                'title' => $title,
                'url' => BlogPostHelper::createURL($title)
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
     * Returns the view for the 5 most recent blog posts
     * 
     * @return View $page
     */
    public static function view(): \Illuminate\Contracts\View\View {
        $posts = BlogPost::orderby('date', 'desc')->take(5)->get();
        foreach ($posts as $post) {
            $post->rawtext = $post->blogtext;
            $post->blogtext = BlogPostHelper::getBlogtextFormat(strip_tags($post->blogtext));
            $post->date = BlogPostHelper::getDateFormat($post->date);
        }
        return view('pages/blog', [
            'posts' => $posts,
            'page' => 1,
            'totalPages' => ceil(BlogPost::count() / 5)
        ]);
    }

    /**
     * Returns the view for a blog page.
     * A page consists of 5 blog posts, which are grouped based on date and the requested increment.
     * 
     * @param int|string $id
     * @return View $page
     */
    public static function viewPage($id): \Illuminate\Contracts\View\View
    {
        if (!is_numeric($id)) {
            abort(404);
        }
        $posts = BlogPost::orderby('date', 'desc')->skip(($id - 1) * 5)->take(5)->get();
        foreach ($posts as $post) {
            $post->rawtext = $post->blogtext;
            $post->blogtext = BlogPostHelper::getBlogtextFormat(strip_tags($post->blogtext));
            $post->date = BlogPostHelper::getDateFormat($post->date);
        }
        return view('pages/blog', [
            'posts' => $posts,
            'page' => $id,
            'totalPages' => ceil(BlogPost::count() / 5)
        ]);
    }

    /**
     * Returns the view for an individual blog post
     * 
     * @param string $id
     * @return View $page
     */
    public static function viewPost(string $id): \Illuminate\Contracts\View\View {
        $post = BlogPost::where('url', $id)->first();
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
