
<div class="dropdown">
    <span class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-sliders"></i>
    </span>
    <ul class="dropdown-menu">
        @foreach ($actions as $label => $action)
            @switch($label)
                @case('edit')
                    <li>
                        <a class="dropdown-item" href="{{ $action['url'] }}">
                            <span><i class="fa-regular fa-pen-to-square"></i></span>
                            <span class="ms-2">{{ __('Edit') }}</span>
                        </a>
                    </li>
                    @break
                @case('delete')
                    <li>
                        <form action="{{ $action['url'] }}" method="post" class="dropdown-item">
                            @csrf
                            @method('delete')
                            <button class="dropdown-btn btn-with-confirm">
                                <span><i class="fa-solid fa-trash-can"></i></span>
                                <span class="ms-2">{{ __('Delete') }}</span>
                            </button>
                        </form>
                    </li>
                    @break
                @default
                    
            @endswitch
            
        @endforeach
    </ul>
</div>