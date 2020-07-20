<h1>喔靠！我找不到你要的東西 :(</h1>

@if($otherVersions->isEmpty())
    <p>這裡什麼都沒有。</p>
@else
    <p>這個版本的 Laravel 並沒有翻譯這頁內容，但你可以在其他版本當中找到這頁的翻譯。</p>

    <div class="content-list">
        <ul>
            @foreach($otherVersions as $key => $title)
                <li><a href="{{ url('/docs/'.$key.'/'.$page) }}">{{ $title }}</a></li>
            @endforeach
        </ul>
    </div>
@endif
