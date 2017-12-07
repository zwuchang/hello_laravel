@foreach(['danger','warning','success','info'] as $msg)
    @if(session()->has($msg))
        <div class="flash-message">
            <p class="alert alert-{{ $msg }}">
                {{ session()->get($msg) }}
                @if(session()->has('url'))
                    <a href="{{ session()->get('url') }}">查看</a>
                @endif
            </p>
        </div>
    @endif
@endforeach