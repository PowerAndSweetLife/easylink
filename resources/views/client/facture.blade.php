@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Facturation") }}</h2>

<div class="main-content">
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped table-text-left">
            <thead>
                <tr>
                    <th scope="col">{{ __('Booking reference') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Amount') }}</th>
                    <th scope="col" class="table-column-action">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $item)
                    <tr>
                        <td>{{ $item->reference }}</td>
                        <td>
                            @if ((int)$item->is_paid)
                                <strong class="text-success">{{ __('Paid') }}</strong>
                            @else
                                <strong class="text-danger">{{ __('Not paid') }}</strong>
                            @endif
                        </td>
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
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('client.facture.history', ['id' => $item->id]) }}">
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