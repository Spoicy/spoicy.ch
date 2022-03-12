@php
use App\Http\Controllers\GitHub;
@endphp
<h2>GitHub</h2>
@foreach ($variables['githubThree'] as $key => $entry)
    <div class="entry">
        <h3><a href="{{$entry->link}}">{{$entry->title}}</a></h3>
        <div class="entry-main">
            @switch($entry->type)
                @case("Push")
                    <div class="entry-link">
                        <a href="https://github.com/{{$entry->author}}">{{$entry->author}}</a> pushed to <a href="https://github.com/{{$entry->repo}}/tree/{{$entry->branch}}">{{$entry->branch}}</a> in <a href="https://github.com/{{$entry->repo}}">{{$entry->repo}}</a>
                        <span>{{$entry->datetime}}</span>
                    </div>
                    <div class="entry-actions">
                        @if (count($entry->commits) > 1)
                            <span>{{count($entry->commits)}} commits to </span><a href="https://github.com/{{$entry->repo}}/tree/{{$entry->branch}}">{{$entry->branch}}</a>
                        @else
                            <span>1 commit to </span><a href="https://github.com/{{$entry->repo}}/tree/{{$entry->branch}}">{{$entry->branch}}</a>
                        @endif
                        <ul>
                            @foreach ($entry->commits as $commit)
                                <li>
                                    <a href="{{$commit->link}}">{{$commit->id}} </a><span>{{$commit->message}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @break
                @case("Issue")
                    <div class="entry-link">
                        <a href="https://github.com/{{$entry->author}}">{{$entry->author}}</a> {{$entry->issuetype}} an issue in <a href="https://github.com/{{$entry->repo}}">{{$entry->repo}}</a>
                        <span>{{$entry->datetime}}</span>
                    </div>
                    <div class="entry-actions">
                        <a href="{{$entry->link}}">{{$entry->issuename}}</a><span>#{{$entry->issuenum}}</span>
                    </div>
                    @break
                @case("Watch")
                    <div class="entry-link">
                        <a href="https://github.com/{{$entry->author}}">{{$entry->author}}</a> starred <a href="https://github.com/{{$entry->repo}}">{{$entry->repo}}</a>
                        <span>{{$entry->datetime}}</span>
                    </div>
                    <div class="entry-actions">
                        <a href="https://github.com/{{$entry->repo}}">{{$entry->repo}}</a>
                        <br>
                        <p>{{$entry->repodesc}}</p>
                    </div>
                    @break
            @endswitch
        </div>
    </div>
@endforeach