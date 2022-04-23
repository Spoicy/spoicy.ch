@php
use App\Http\Controllers\Youtube;
@endphp
<h2>YouTube</h2>
@foreach ($variables['youtubeVideos'] as $key => $video)
    <div class="row video">
        <div class="col-lg-4 col-md-3 col-sm-4 col-5 video-thumbnail">
            <a href="https://www.youtube.com/watch?v={{$video->sid}}">
                <img src="{{$video->thumbnail}}" alt="Thumbnail" />
            </a>
        </div>
        <div class="col-lg-8 col-md-9 col-sm-8 col-7 video-text">
            <a href="https://www.youtube.com/watch?v={{$video->sid}}">{{$video->title}}</a>
            <br>
            <span class="video-date">{{Youtube::getDateFormat($video->date)}}</span>
        </div>
    </div>
@endforeach