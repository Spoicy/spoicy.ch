@php
    $links = [
        "hHome" => ["/", "Home"],
        "hLinktree" => ["/linktree", "Linktree"],
        "hSocial" => ["/social", "Social Media Stream"],
        "hJSFrameworks" => ["/jsframework", "JS-Frameworks"],
        "hBlog" => ["/blog", "Blog"]
    ];
@endphp
<div class="overlay-container">
    <div class="inner-overlay">
        <div class="background-dim" id="bDim"></div>
        <div class="menuburger">
            <button id="mbButton"><i class="fa fa-bars"></i></button>
        </div>
        <div class="github-ico">
            <a class="fa fa-github" href="https://github.com/Spoicy/spoicy.ch" aria-label="Source code link" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Source code"></a>
        </div>
        <nav class="menu-popout" id="mPopout">
            <button id="mcButton"><i class="fa fa-times"></i></button>
            <ul>
                @foreach ($links as $key => $data)
                    @if ($key == $nav)
                        <li><a class="link-active" href="{{$data[0]}}" id="{{$key}}">{{$data[1]}}</a></li>
                    @else
                        <li><a href="{{$data[0]}}" id="{{$key}}">{{$data[1]}}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>