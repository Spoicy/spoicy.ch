@php
    use App\Http\Controllers\Blog;
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
        <link rel="stylesheet" href="../css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Blog</title>
    </head>
    <body class="light-orange">
        @include('components/other/overlay', ['nav' => 'hBlog'])
        <div class="container blog-container site-container">
            <div class="main-div">
                <h1 class="text-center">Blog</h1>
                @if (session('loggedin') && Hash::check(session('loggedin'), env("BLOG_PASS")))
                    <div class="admin-div mb-3">
                        <form action="/blog/add" method="post">
                            @csrf
                            <textarea class="form-control mb-2" name="blogTextarea" id="blogTextarea" rows="6"></textarea>
                            <button class="btn btn-secondary float-right">Add entry</button>
                        </form>
                    </div>
                @endif
                <div class="blog-cards">
                    @foreach ($entries as $entry)
                        <div class="blog-card">
                            <h2>{{Blog::getDateFormat($entry->date)}}</h2>
                            <div id="blogEntryText{{$entry->id}}">{!! Blog::getBlogtextFormat($entry->blogtext) !!}</div>
                            @if (session('loggedin') && Hash::check(session('loggedin'), env("BLOG_PASS")))
                                <button class="button-blog-edit" id="blogEditButton{{$entry->id}}"><i class="fa fa-pencil" id="blogEditButton{{$entry->id}}"></i></button>
                                <form action="/blog/edit/{{$entry->id}}" method="post">
                                    @csrf
                                    <textarea class="d-none" name="blogEditText{{$entry->id}}" id="blogEditText{{$entry->id}}" rows="6">{{$entry->rawtext}}</textarea>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-secondary d-none" id="blogSaveEntry{{$entry->id}}">Save entry</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>