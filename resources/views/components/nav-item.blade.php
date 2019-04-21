{{--
    [
        'icon'      => '',
        'url'       => '',
        'text'      => '',
        'dropdown'  => [
            [
                'url'       => '',
                'text'      => '',
            ],
        ]
    ]
--}}

<li class="nav-item 
           {{ url()->current() == url($url) && !isset($dropdown) ? 'active' : '' }}
           {{ isset($dropdown) ? 'dropdown' : '' }}">
    <a class="nav-link {{ isset($dropdown) ? 'dropdown-toggle' : '' }}"
       href="{{ url($url) }}"
       {{ isset($dropdown) ? 'id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : '' }}>
        <i class="fas fa-fw fa-{{ $icon }}"></i>
        <span>{{ $text }}</span>
    </a>
    @if (isset($dropdown))
        @php
            $dd_active = false;

            foreach ($dropdown as $d) {
                if (url()->current() == url($d['url'])) {
                    $dd_active = true;
                }
            }
        @endphp
        <div class="dropdown-menu {{ $dd_active ? 'show' : '' }}"
             aria-labelledby="pagesDropdown"
             x-placement="bottom-start"
             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(5px, 56px, 0px);">
            @foreach ($dropdown as $item)
                @if ($item == 'divider')
                    <div class="dropdown-divider"></div>
                @else
                    <a class="dropdown-item {{ url()->current() == url($item['url']) ? 'active' : '' }}" href="{{ url($item['url']) }}">
                        {{ $item['text'] }}
                    </a>
                @endif
            @endforeach
        </div>        
    @endif
</li>