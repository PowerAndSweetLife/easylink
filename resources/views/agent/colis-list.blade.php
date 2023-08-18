@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Shipping lists") }}</h2>

<ul class="nav nav-underline nav-swipe mb-4">
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $active === 'not-received']) 
            href="{{ route('agent.colis.list', ['status' => 'not-received']) }}">
            {{ __("Not received") }}
        </a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $active === 'received']) 
            href="{{ route('agent.colis.list', ['status' => 'received']) }}">
            {{ __("Received") }}
        </a>
    </li>
</ul>

<div class="main-content">
    <form class="row mb-2">
        <div class="col-md-8"></div>
        <div class="col-md-4 d-flex">
            @if ($active === 'not-received')
                <input type="search" name="query" value="{{ $query ?? null }}" class="form-control" placeholder="{{ __('Filter by package number') }}">
            @else
                <input type="search" name="query" value="{{ $query ?? null }}" class="form-control" placeholder="{{ __('Filter by shiporder or package number') }}">  
            @endif
            <button class="btn btn-primary w-25">{{ __('Filter') }}</button>
        </div>
    </form>
    @if ($active === 'not-received')
        <form class="mb-2 d-none" id="form-for-checkbox" action="{{ route('agent.colis.receiveMore') }}" method="POST">
            @csrf
            @method('put')
            <button class="btn btn-danger">
                {{ __("Receive selected") }}
                <span class="badge bg-primary ms-2" id="checked-count"></span>
            </button>
        </form>
    @endif
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped">
            <thead>
                <tr>
                    @if (count($lists) && $active === 'not-received')
                        <th scope="col" style="width: 20px"><input type="checkbox" id="check-all"></th>
                    @else
                        <th scope="col">{{ __('Shiporder') }}</th>
                    @endif
                    <th scope="col">{{ __('Bordereau') }}</th>
                    <th scope="col">{{ __('Client ID') }}</th>
                    <th scope="col">{{ __('Category') }}</th>
                    <th scope="col" class="text-center">{{ __('Number of packages') }}</th>
                    <th scope="col" class="text-center">{{ __('Volume | Weight') }}</th>
                    <th scope="col">{{ __('Sending date') }}</th>
                    <th scope="col" class="table-column-action">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $item)
                    <tr>
                        @if (count($lists) && $active === 'not-received')
                            <td><input type="checkbox" class="check-item" name="id-list[]" value="{{ $item->id }}"></td>
                        @else
                            <th scope="col">{{ $item->shiporder }}</th>
                        @endif
                        <td>{{ $item->receip_number }}</td>
                        <td>{{ $item->client->uid }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td class="text-center">{{ $item->number() > 0 ? $item->number() : '----' }}</td>
                        <td class="text-center">
                            {{ $item->volume() > 0 ? $item->volume() . " m³" : '----' }}  | {{ $item->weight() > 0 ? $item->weight() . ' kg' : '----'}}
                        </td>
                        <td>{{ $item->sendAt()->format('d/m/Y') }}</td>
                        <td class="table-column-action">
                            <div class="dropdown">
                                <span class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-sliders"></i>
                                </span>
                                <ul class="dropdown-menu">
                                    @if ($active === 'not-received')
                                        <li>
                                            <form action="{{ route('agent.colis.receive') }}" method="post" class="dropdown-item">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="colis-id" value="{{ $item->id }}">
                                                <button class="dropdown-btn">
                                                    <span><i class="fa-solid fa-hand-holding-hand"></i></span>
                                                    <span class="ms-2">{{ __('Receive') }}</span>
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('agent.colis.show', ['id' => $item->id]) }}">
                                            <span><i class="fa-solid fa-circle-info"></i></span>
                                            <span class="ms-2">{{ __('Detail') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    <div class="paginator mt-4">
        {{ $lists->links() }}
    </div>
</div>

@endsection