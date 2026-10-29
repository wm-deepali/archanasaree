@if ($paginator->hasPages())
<nav class="listing-pagination" aria-label="Product pages">
  @if ($paginator->onFirstPage())
    <a href="javascript:void(0)" class="pg-nav is-disabled" aria-disabled="true"><i class="fa-solid fa-arrow-left-long"></i> Previous</a>
  @else
    <a href="{{ $paginator->previousPageUrl() }}" class="pg-nav" rel="prev"><i class="fa-solid fa-arrow-left-long"></i> Previous</a>
  @endif

  <ul>
    @foreach ($elements as $element)
      @if (is_string($element))
        <li class="dots">…</li>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          <li>
            <a href="{{ $url }}" @if ($page == $paginator->currentPage()) class="active" aria-current="page" @endif>{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
          </li>
        @endforeach
      @endif
    @endforeach
  </ul>

  @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="pg-nav" rel="next">Next <i class="fa-solid fa-arrow-right-long"></i></a>
  @else
    <a href="javascript:void(0)" class="pg-nav is-disabled" aria-disabled="true">Next <i class="fa-solid fa-arrow-right-long"></i></a>
  @endif
</nav>
@endif