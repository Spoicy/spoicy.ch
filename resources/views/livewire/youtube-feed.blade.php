@php
    use App\Helpers\YoutubeVideoHelper;
@endphp

<div>
    <div class="filter-buttons">
        <button wire:click="changeFilter('Latest')" class="btn {{ $filter == 'Latest' ? 'active' : ''}}"
            name="changeFilterLatest" id="changeFilterLatest" value="Latest">Latest</button>
        <button wire:click="changeFilter('Popular')" class="btn {{ $filter == 'Popular' ? 'active' : ''}}"
            name="changeFilterPopular" id="changeFilterPopular" value="Popular">Popular</button>
    </div>
    @foreach ($videos as $video)
        <div class="row video">
            <div class="col-lg-4 col-md-3 col-sm-4 col-5 video-thumbnail">
                <a href="https://www.youtube.com/watch?v={{$video->sid}}">
                    <img src="{{$video->thumbnail}}" alt="Thumbnail" />
                </a>
            </div>
            <div class="col-lg-8 col-md-9 col-sm-8 col-7 video-text">
                <a href="https://www.youtube.com/watch?v={{$video->sid}}">{{$video->title}}</a>
                <br>
                <span class="video-date">{{YoutubeVideoHelper::getDateFormat($video->date)}} · {{YoutubeVideoHelper::getViewFormat($video->views)}}</span>
            </div>
        </div>
    @endforeach
</div>
