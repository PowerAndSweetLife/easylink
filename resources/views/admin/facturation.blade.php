@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Facturation") }}</h2>

<ul class="nav nav-underline nav-swipe mb-4">
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $active === 'not-paid']) href="{{ route('admin.facturation.index', ['status' => 'not-paid']) }}">{{ __("Not Paid") }}</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $active === 'paid']) href="{{ route('admin.facturation.index', ['status' => 'paid']) }}">{{ __("Paid") }}</a>
    </li>
</ul>

<div class="main-content">
    <form class="mb-2">
        <input type="hidden" name="status" value="{{ $active }}">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5 d-flex">
                <div style="flex: 1">
                    @include('elements.input', [
                        'name' => 'uid',
                        'label' => 'Client ID',
                        'type' => 'search',
                        'default' => $uid ?? null
                    ])
                </div>
                <div>
                    <label class="d-block w-100" style="height: 1.15rem"></label>
                    <button class="btn btn-success" style="padding: .45rem 2rem">{{ __('Filter') }}</button>
                </div>
            </div>
        </div>
    </form>
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped table-text-left">
            <thead>
                <tr>
                    <th scope="col">{{ __('Booking reference') }}</th>
                    <th scope="col">{{ __('Client ID') }}</th>
                    <th scope="col">{{ __('Client name') }}</th>
                    <th scope="col">{{ __('Dimension') }}</th>
                    <th scope="col">{{ __('Amount') }}</th>
                    <th scope="col" class="table-column-action">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $item)
                    <tr>
                        <td>{{ $item->booking->reference }}</td>
                        <td>{{ $item->booking->client->uid }}</td>
                        <td>{{ $item->booking->client->shortName() }}</td>
                        <td>{{ $item->booking->volume() }} m³</td>
                        <td>
                            @if ($item->amount_ariary)
                                <p class="row m-0">
                                    <span class="col-4 ps-0 text-muted">Total :</span> 
                                    <strong class="col-8">{{ price($item->amount_ariary) }} Ar</strong>
                                </p>
                                <p class="row m-0">
                                    <span class="col-4 ps-0 text-muted">{{ __('Acompte') }} :</span> 
                                    <strong class="col-8 text-success">{{ price($item->amount_paid ?? 0) }} Ar</strong>
                                </p>
                                <p class="row m-0">
                                    <span class="col-4 ps-0 text-muted">{{ __('Reliquat') }} :</span> 
                                    <strong class="col-8 text-danger">{{ price($item->rest ?? $item->amount_ariary) }} Ar</strong>
                                </p>
                            @endif
                        </td>
                        <td class="table-column-action">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.facturation.history', ['id' => $item->id]) }}">
                                <span><i class="fa-solid fa-clock-rotate-left"></i></span>
                                <span class="ms-2">{{ __('History') }}</span>
                            </a>
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