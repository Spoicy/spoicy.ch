@php
use App\Http\Controllers\GitHub;
@endphp
<h2>GitHub</h2>
@foreach ($variables['githubEntries'] as $key => $entry)
    @php
        $entry->entrydata = json_decode($entry->entrydata);
    @endphp
    <div class="entry">
        <h3><a href="{{$entry->link}}">{{$entry->title}}</a></h3>
        <div class="entry-main">
            @switch($entry->type)
                @case("Push")
                    <div class="entry-link">
                        <a href="https://github.com/{{$entry->author}}">{{$entry->author}}</a> pushed to <a href="https://github.com/{{$entry->entrydata->repo}}/tree/{{$entry->entrydata->branch}}">{{$entry->entrydata->branch}}</a> in <a href="https://github.com/{{$entry->entrydata->repo}}">{{$entry->entrydata->repo}}</a>
                        <span>{{GitHub::getDateFormat($entry->date)}}</span>
                    </div>
                    <div class="entry-actions">
                        @if (count($entry->entrydata->commits) > 1)
                            <span>{{count($entry->entrydata->commits)}} commits to </span><a href="https://github.com/{{$entry->entrydata->repo}}/tree/{{$entry->entrydata->branch}}">{{$entry->entrydata->branch}}</a>
                        @else
                            <span>1 commit to </span><a href="https://github.com/{{$entry->entrydata->repo}}/tree/{{$entry->entrydata->branch}}">{{$entry->entrydata->branch}}</a>
                        @endif
                        <ul>
                            @foreach ($entry->entrydata->commits as $commit)
                                <li>
                                    <a href="{{$commit->link}}">{{$commit->id}} </a><span>{{$commit->message}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @break
                @case("Issue")
                    <div class="entry-link">
                        <a href="https://github.com/{{$entry->author}}">{{$entry->author}}</a> {{$entry->entrydata->issuetype}} an issue in <a href="https://github.com/{{$entry->entrydata->repo}}">{{$entry->entrydata->repo}}</a>
                        <span>{{GitHub::getDateFormat($entry->date)}}</span>
                    </div>
                    <div class="entry-actions">
                        <a href="{{$entry->link}}">{{$entry->entrydata->issuename}}</a><span> #{{$entry->entrydata->issuenum}}</span>
                    </div>
                    @break
                @case("Watch")
                    <div class="entry-link">
                        <a href="https://github.com/{{$entry->author}}">{{$entry->author}}</a> starred <a href="https://github.com/{{$entry->entrydata->repo}}">{{$entry->entrydata->repo}}</a>
                        <span>{{GitHub::getDateFormat($entry->date)}}</span>
                    </div>
                    <div class="entry-actions">
                        <a href="https://github.com/{{$entry->entrydata->repo}}">{{$entry->entrydata->repo}}</a>
                        <br>
                        <p>{{$entry->entrydata->repodesc}}</p>
                    </div>
                    @break
            @endswitch
        </div>
    </div>
@endforeach