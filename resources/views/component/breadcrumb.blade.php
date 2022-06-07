<ol class="breadcrumb float-sm-right">
    @foreach ($breadcrumbs as $breadcrumb)
        @if (!empty($breadcrumb['active']))
            <li class="breadcrumb-item {{ $breadcrumb['active'] ?? '' }}">{{ $breadcrumb['name'] }}</li>
        @else
            <li class="breadcrumb-item {{ $breadcrumb['active'] ?? '' }}"><a href="#">{{ $breadcrumb['name'] }}</a></li>
        @endif
    @endforeach
</ol>
