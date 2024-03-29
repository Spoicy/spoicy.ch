@php
    use App\Helpers\GithubEventHelper;
@endphp
<div class="entry-link">
    <a href="https://github.com/{{$entry->author}}">{{$entry->author}}</a> starred <a href="https://github.com/{{$entry->entrydata->repo}}">{{$entry->entrydata->repo}}</a>
    <span>{{GithubEventHelper::getDateFormat($entry->date)}}</span>
</div>
<div class="entry-actions">
    <a href="https://github.com/{{$entry->entrydata->repo}}">{{$entry->entrydata->repo}}</a>
    <br>
    <p>{{$entry->entrydata->repodesc}}</p>
</div>