@php
    $crumbs = $crumbs ?? [];
    $last   = count($crumbs) - 1;

    $ld = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => collect($crumbs)->values()->map(fn ($c, $i) => array_filter([
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $c['label'],
            'item'     => $c['url'] ?? null,
        ]))->all(),
    ];
@endphp

<ul class="crumb">
    @foreach ($crumbs as $i => $c)
        @if ($i > 0)
            <li><i class="fa-solid fa-chevron-right"></i></li>
        @endif

        @if ($i === $last)
            <li class="current">{{ $c['label'] }}</li>
        @elseif (!empty($c['url']))
            <li><a href="{{ $c['url'] }}">{{ $c['label'] }}</a></li>
        @else
            <li>{{ $c['label'] }}</li>
        @endif
    @endforeach
</ul>

<script type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>