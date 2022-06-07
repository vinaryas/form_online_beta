<div class="dropdown">
    <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton_{{ $id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Aksi
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_{{ $id }}">
        @foreach ($actions as $action)
            @if (!empty($action['url']))
                @if (!empty($action['can']))
                    @if (Laratrust::isAbleTo($action['can']))
                        <a class="dropdown-item {{ $action['class'] ?? '' }}" href="{{ $action['url'] }}">
                            {{ $action['label'] }}
                        </a>
                    @endif
                @else
                    <a class="dropdown-item {{ $action['class'] ?? '' }}" href="{{ $action['url'] }}">
                        {{ $action['label'] }}
                    </a>
                @endif
            @else

                @if (!empty($action['can']))
                    @if (Laratrust::isAbleTo($action['can']))
                        <button onclick="{{ (!empty($action['onclick'])) ? $action['onclick'] : '' }}" class="dropdown-item {{ $action['class'] ?? '' }}" type="button">
                            {{ $action['label'] }}
                        </button>
                    @endif
                @else
                    <button onclick="{{ (!empty($action['onclick'])) ? $action['onclick'] : '' }}" class="dropdown-item {{ $action['class'] ?? '' }}" type="button">
                        {{ $action['label'] }}
                    </button>
                @endif
            @endif
        @endforeach
    </div>
</div>
