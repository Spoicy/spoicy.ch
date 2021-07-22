@php
use App\Http\Controllers\Youtube;
@endphp
<h1>YouTube</h1>
@foreach ($variables['youtubeFive'] as $key => $video)
    <div class="row video">
        <div class="col-lg-4 col-md-3 col-sm-4 col-5 video-thumbnail">
            <a href="https://www.youtube.com/watch?v={{$video->id}}">
                <img src="{{$video->thumbnail}}" alt="Thumbnail" />
            </a>
        </div>
        <div class="col-lg-8 col-md-9 col-sm-8 col-7 video-text">
            <a href="https://www.youtube.com/watch?v={{$video->id}}">{{$video->title}}</a>
            <br>
            <span class="video-date">{{$video->date}}</span>
        </div>
    </div>
@endforeach