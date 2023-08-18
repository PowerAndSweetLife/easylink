@extends('base')

@section('content')


<h2 class="fs-18 py-2 text-primary">
    {{__("Paiement")}} - {{ $data->booking->reference }}
</h2>

<div class="main-content">
    @php
        $default = $data->rest > 0 ? $data->rest : $data->amount_ariary
    @endphp
    <div class="mt-3">
        <div class="row">
            <div class="col-12">
                <span class="fs-18">Client ID:</span>
                <strong class="fs-18 ms-4">{{ $data->booking->client->uid }}</strong>
            </div>
            <div class="col-12">
                <span class="fs-18">{{ __('Client name') }}:</span> 
                <strong class="fs-18 ms-4">
                    {{ $data->booking->client->shortName() }}
                </strong>
            </div>
        </div>
        <div class="d-flex mt-3">
            <div class="d-flex flex-column">
                <span class="fs-18 text-muted">{{ __('Total') }} (Ar):</span>
                <span class="fs-18 text-muted">{{ __('Acompte') }} (Ar) :</span>
                <span class="fs-18 text-muted">{{ __('Reliquat') }} (Ar) :</span>
            </div>
            <div class="mx-4"></div>
            <div class="d-flex flex-column">
                <strong class="fs-18">{{ price($data->amount_ariary) }}</strong>
                <strong class="fs-18 text-success">{{ price($data->amount_paid ?? 0) }}</strong>
                <strong class="fs-18 text-danger">{{ price($data->rest ?? 0) }}</strong>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.facturation.paiement', ['id' => $data->id]) }}" method="POST" class="mt-3">
        @method('put')
        @csrf
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Amount'),
                'name' => 'amount',
                'default' => $default,
                'class' => ['number-only']
            ])
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-primary" style="min-width: 25%">
                {{__('Pay')}}
            </button>
        </div>
    </form>
</div>
@endsection