@php
use App\Http\Controllers\Twitter;
@endphp
<h2>Twitter</h2>
@foreach ($variables['twitterPosts'] as $key => $tweet)
    <div class="row tweet">
        @if ($tweet->media)
            <div class="col-lg-8 col-md-9 col-sm-8 col-7 tweet-text">
                <a href="https://twitter.com/OnlyFireball_">@OnlyFireball_</a>
                <br>
                <span>{{$tweet->text}}</span>
                <a href="{{$tweet->link}}"><i class="fa fa-external-link"></i></a>
                <br>
                <p>{{$tweet->date}}</p>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-4 col-5 tweet-media">
                <a href="{{$tweet->link}}">
                    <img src="{{$tweet->media}}" alt="Thumbnail" />
                </a>
            </div>
        @else
            <div class="col-12 tweet-text">
                <a href="https://twitter.com/OnlyFireball_">@OnlyFireball_</a>
                <br>
                <span>{{$tweet->text}}</span>
                <a href="{{$tweet->link}}"><i class="fa fa-external-link"></i></a>
                <br>
                <p>{{$tweet->date}}</p>
            </div>
        @endif
    </div>
@endforeach