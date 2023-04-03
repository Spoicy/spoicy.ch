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
        <title>{{$post->title}} | {{$post->date}}</title>
    </head>
    <body class="light-orange">
        @include('components/other/overlay', ['nav' => 'hBlog', 'title' => 'Blog'])
        <div class="container blog-container site-container">
            <div class="main-div">
                <a class="btn btn-secondary btn-return" href="/blog" style="--order: 0"><i class="fa fa-fast-backward" aria-hidden="true"></i> &nbsp;Return</a>
                <div class="blog-cards" style="--order: 0">
                    <div class="blog-card">
                        <h2 class="mb-0">{{$post->title}}</h2>
                        <p class="text-secondary">{{$post->date}}</p>
                        <div id="blogEntryText{{$post->id}}">{!! $post->blogtext !!}</div>
                        @if (session('loggedin') && Hash::check(session('loggedin'), env("BLOG_PASS")))
                            <div class="blog-buttons">
                                <button class="button-blog-edit" id="blogEditButton{{$post->id}}"><i class="fa fa-pencil" id="blogEditButton{{$post->id}}"></i></button>
                            </div>
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
                </div>
            </div>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>