

@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Booking list") }}</h2>

<div class="main-content">
    <form class="mb-2 d-none row" id="form-for-checkbox" action="{{ route('agent.booking.containerMore') }}" method="POST" onsubmit="chooseContainer(event,this)">
        <div class="col-6">
            <button class="btn btn-danger">
                {{ __("Add to container") }}
                <span class="badge bg-primary ms-2" id="checked-count"></span>
            </button>
        </div>
        <div class="col-6">
            <strong class="fs-24 text-success" id="total-cbm-to-container"></strong>
        </div>
        
    </form>
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped">
            <thead>
                <tr>
                    @if (count($lists))
                        <th scope="col" style="width: 20px"><input type="checkbox" id="check-all"></th>
                    @endif
                    <th scope="col">{{ __('Reference') }}</th>
                    <th scope="col">{{ __('Client ID') }}</th>
                    <th scope="col">{{ __('Client name') }}</th>
                    <th scope="col" class="text-center">{{ __('Number of shiporder') }}</th>
                    <th scope="col" class="text-center">{{ __('Volume') }}</th>
                    <th scope="col" class="table-column-action">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $item)
                    <tr>
                        @if (count($lists))
                            <td><input type="checkbox" class="check-item" name="id-list[]" value="{{ $item->id }}" data-cbm="{{ $item->volume() }}"></td>
                        @endif
                        <td>{{ $item->reference }}</td>
                        <td>{{ $item->client->uid }}</td>
                        <td>{{ $item->client->shortName() }}</td>
                        <td class="text-center d-flex align-items-center justify-content-center">
                            <span class="link-to-more">
                                <span>
                                    <p class="m-0 fs-600">{{ $item->colis->count() }}</p>
                                    <p class="m-0">
                                        <a href="{{ route('agent.booking.show', ['id' => $item->id]) }}" onclick="openDetailModal(event, this)">{{ __('Detail') }}</a>
                                    </p>
                                </span>
                            </span>
                        </td>
                        <td class="text-center">{{ $item->volume() }} m³</td>
                        <td class="table-column-action">
                            <div class="dropdown">
                                <span class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-sliders"></i>
                                </span>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('agent.booking.container') }}" class="dropdown-item" method="post" onsubmit="chooseContainer(event,this)">
                                            <input type="hidden" name="booking-id" value="{{ $item->id }}">
                                            <button class="dropdown-btn">
                                                <span><i class="fa-solid fa-box-open"></i></span>
                                                <span class="ms-2">{{ __('Add to container') }}</span>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <a href="{{ route('agent.booking.show', ['id' => $item->id]) }}" class="dropdown-item" onclick="openDetailModal(event, this)">
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

@include('agent.modal.add-to-container')
@include('agent.modal.package-lists')

@endsection

@section('javascript')
    <script src="{{ asset('assets/js/agent.js') }}"></script>
@endsection