<nav>
    <ul class="pagination">
        @if($page > 1)
            <li>
                <a href="{{ $url }}&page={{ $page - 1}}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        @endif
        @for($i = 0; $i < 5; $i ++)
            @continue($page - 2 + $i <= 0)
            @continue($page - 2 + $i > $pageCount)
            <li
                    @if((int)$i == 2)
                    class="active"
                    @endif
                    >
                <a href="{{ $url }}&page={{ $page - 2 + $i }}">{{ $page - 2 + $i }}</a>
            </li>
        @endfor
        @if($page < $pageCount )
            <li>
                <a href="{{ $url }}&page={{ $page + 1 }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        @endif
    </ul>
</nav>