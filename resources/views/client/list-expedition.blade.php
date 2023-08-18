@extends('base')

@section('content')
<h2 class="fs-18 py-2 text-primary">{{ __("My shipments") }}</h2>
@if (isset($searchResult))
    <div class="main-content">
        <div class="row mb-3">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <form action="{{ route('client.search.index') }}" class="d-flex">
                    <input type="search" name="package" value="{{ $query ?? null }}" class="form-control" placeholder="{{ __('Package number') }}">
                    <button class="btn btn-primary">{{ __('Search') }}</button>
                </form>
            </div>
        </div>

        <h5>{{__('Search result')}} - {{ $query }}</h5>
        @if ($match)
            <table class="w-100 text-start table table-bordered table-text-left">
                <tr>
                    <td class="w-25">{{ __("Category") }}</td>
                    <td><strong>{{ $match->category->name }}</strong></td>
                </tr>
                <tr>
                    <td class="w-25">{{ __("Description") }}</td>
                    <td><strong>{{ $match->description }}</strong></td>
                </tr>
                <tr>
                    <td class="w-25">{{ __("Courrier company") }}</td>
                    <td><strong>{{ $match->courrier_company }}</strong></td>
                </tr>
                <tr>
                    <td class="w-25">{{ __("Number of parcels") }}</td>
                    <td><strong>{{ $match->number() }}</strong></td>
                </tr>
                <tr>
                    <td class="w-25">{{ __("Volume") }}</td>
                    <td><strong>{{ $match->volume() }} m³</strong></td>
                </tr>
                <tr>
                    <td class="w-25">{{ __("Weight") }}</td>
                    <td><strong>{{ $match->weight() }} kg</strong></td>
                </tr>
                <tr>
                    <td class="w-25">{{ __("Status") }}</td>
                    <td><strong class="text-success">{{ __($match->status) }}</strong></td>
                </tr>
            </table>
            @if ($match->status === 'send')
                <div class="d-flex justify-content-end gap-2">
                    <form action="{{ route('client.colis.destroy', ['coli' => $match]) }}" method="post" class="d-inline-block">
                        @method('delete')
                        @csrf
                        <button class="btn btn-sm btn-danger btn-with-confirm">
                            <span class="me-1"><i class="fa-regular fa-trash-can"></i></span>
                            {{ __('Delete') }}
                        </button>
                    </form>
                    <a href="{{ route('client.colis.edit', ['coli' => $match]) }}" class="btn btn-sm btn-success" style="min-width: 120px">
                    <span class="me-1"><i class="fa-regular fa-pen-to-square"></i></span>
                    {{ __('Edit') }}
                    </a>
                </div>
            </div>
            @endif
        @else
            <div class="text-center pt-5">{{ __('No records') }}</div>
        @endif
    </div>
@else
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <form action="{{ route('client.search.index') }}" class="d-flex">
                    <input type="search" name="package" value="{{ $query ?? null }}" class="form-control" placeholder="{{ __('Package number') }}">
                    <button class="btn btn-primary">{{ __('Search') }}</button>
                </form>
            </div>
        </div>
        <div class="d-flex border-bottom">
            <a @class(['expedition-tab-link', 'active' => $status === 'en-cours']) href="{{ route('client.expedition.index', ['status' => 'en-cours']) }}">
                <span>{{ __('Receiving') }} <span class="badge bg-secondary">{{ $count['en-cours'] }}</span></span>
            </a>
            <a @class(['expedition-tab-link', 'active' => $status === 'recu']) href="{{ route('client.expedition.index', ['status' => 'recu']) }}">
                <span>{{ __('Received') }} <span class="badge bg-primary">{{ $count['recu'] }}</span></span>
            </a>
            <a @class(['expedition-tab-link', 'active' => $status === 'a-expedier']) href="{{ route('client.expedition.index', ['status' => 'a-expedier']) }}">
                <span>{{ __('Shipping') }} <span class="badge bg-warning">{{ $count['a-expedier'] }}</span></span>
            </a>
            <a @class(['expedition-tab-link', 'active' => $status === 'livre']) href="{{ route('client.expedition.index', ['status' => 'livre']) }}">
                <span>{{ __('Delivered') }} <span class="badge bg-success">{{ $count['livre'] }}</span></span>
            </a>
        </div>
        <div class="expedition-tab-content py-4">
            @if ($lists->isEmpty())
                <div class="d-flex w-100 justify-content-center align-items-center vh-50">
                    <span class="text-muted fw-300 fs-18">{{ __('No records') }}</span>
                </div>
            @else
                @switch($status)
                    @case('en-cours')
                        @include('client.components.expedition-tab-sended')
                        @break
                    @case('recu')
                        @include('client.components.expedition-tab-received')
                        @break
                    @case('a-expedier')
                        @include('client.components.expedition-tab-manifested')
                        @break
                    @case('livre')
                        @include('client.components.expedition-tab-delivered')
                        @break
                    @default
                        
                @endswitch
            @endif
        </div>
        <div class="paginator">
            {{ $lists->links() }}
        </div>
    </div>
@endif
@endsection