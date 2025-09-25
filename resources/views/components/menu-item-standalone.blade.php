<div class="menu-item">
    <a href="{{ $route }}" class="menu-link">
        @if(isset($iconClass))
        <span class="menu-icon">
            <i class="{{ $iconClass }}"></i>
        </span>
        @else 
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
        @endif
        <span class="menu-title">{{ $title }}</span>
    </a>
</div>