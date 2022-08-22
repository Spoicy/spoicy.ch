<h2>YouTube</h2>
@foreach ($data as $video)
    <div class="row video">
        <div class="col-lg-4 col-md-3 col-sm-4 col-5 video-thumbnail">
            <a href="https://www.youtube.com/watch?v={{$video->sid}}">
                <img src="{{$video->thumbnail}}" alt="Thumbnail" />
            </a>
        </div>
        <div class="col-lg-8 col-md-9 col-sm-8 col-7 video-text">
            <a href="https://www.youtube.com/watch?v={{$video->sid}}">{{$video->title}}</a>
            <br>
            <span class="video-date">{{$video->date}}</span>
        </div>
    </div>
@endforeach