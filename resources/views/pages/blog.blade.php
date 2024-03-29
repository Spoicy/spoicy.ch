@php
    use Illuminate\Support\Facades\Hash;
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Spoicy's personal blog about various projects and features in development.">
        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Blog</title>
    </head>
    <body class="light-orange">
        @include('components/other/overlay', ['nav' => 'hBlog', 'title' => 'Blog'])
        <div class="container blog-container site-container">
            <div class="main-div">
                @if (session('loggedin') && Hash::check(session('loggedin'), env("BLOG_PASS")))
                    <div class="admin-div mb-3" style="--order: 1">
                        <h3>Create a new post</h3>
                        <form action="/blog/add" method="post">
                            @csrf
                            <label for="blogTitle">Title</label>
                            <input class="form-control mb-2" type="text" name="blogTitle" id="blogTitle">
                            <label for="blogTextarea">Content</label>
                            <textarea class="form-control mb-2" name="blogTextarea" id="blogTextarea" rows="6"></textarea>
                            <button class="btn btn-secondary float-right">Add entry</button>
                        </form>
                    </div>
                @endif
                <div class="blog-cards" style="--order: 1">
                    @foreach ($posts as $post)                            
                        <div class="blog-card">
                            <h2 class="mb-0">{{$post->title ?? "Default title"}}</h2>
                            <p class="text-secondary">{{$post->date}}</p>
                            <div id="blogEntryText{{$post->id}}">{!! $post->blogtext !!}</div>
                            <div class="blog-buttons">
                                <a class="button-blog-view" href="/blog/post/{{$post->url}}"><i class="fa fa-eye"></i></a>
                                @if (session('loggedin') && Hash::check(session('loggedin'), env("BLOG_PASS")))
                                <button class="button-blog-edit" id="blogEditButton{{$post->id}}"><i class="fa fa-pencil" id="blogEditButton{{$post->id}}"></i></button>
                                @endif
                            </div>
                            @if (session('loggedin') && Hash::check(session('loggedin'), env("BLOG_PASS")))
                                <form class="d-none" id="blogEditForm{{$post->id}}" action="/blog/edit/{{$post->id}}" method="post">
                                    @csrf
                                    <label class="d-block" for="blogEditTitle{{$post->id}}">Title:</label>
                                    <input class="d-block mb-2" type="text" name="blogEditTitle{{$post->id}}" id="blogEditTitle{{$post->id}}" value="{{$post->title}}">
                                    <label class="d-block" for="blogEditText{{$post->id}}">Blog text:</label>
                                    <textarea class="d-block mb-2" name="blogEditText{{$post->id}}" id="blogEditText{{$post->id}}" rows="6">{{$post->rawtext}}</textarea>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-secondary" id="blogSaveEntry{{$post->id}}">Save entry</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="page-selection" style="--order: 1">
                    @if ($page > 1 && $page <= $totalPages)
                        <a href="/blog/{{$page - 1}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                    @endif
                    @foreach (range(1, $totalPages) as $pageID)
                        <a href="/blog/{{$pageID}}" class="{{$page == $pageID ? 'active' : ''}}">{{$pageID}}</a>
                    @endforeach
                    @if ($page < $totalPages && $page >= 1)
                        <a href="/blog/{{$page + 1}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    @endif
                </div>
            </div>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>