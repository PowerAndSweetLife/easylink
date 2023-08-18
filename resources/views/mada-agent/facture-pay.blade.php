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
        <div class="d-flex mt-3">
            <table class="table-text-left w-100">
                <tr>
                    <td class="w-15"><span class="fs-18">Client ID:</span></td>
                    <td><strong class="fs-18">{{ $data->booking->client->uid }}</strong></td>
                </tr>
                <tr>
                    <td class="w-15"><span class="fs-18">{{ __('Client name') }}:</span> </td>
                    <td>
                        <strong class="fs-18">
                            {{ $data->booking->client->shortName() }}
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="w-15"><span class="fs-18 text-muted">{{ __('Total') }} (Ar):</span></td>
                    <td><strong class="fs-18">{{ price($data->amount_ariary) }}</strong></td>
                </tr>
                <tr>
                    <td class="w-15"><span class="fs-18 text-muted">{{ __('Acompte') }} (Ar) :</span></td>
                    <td><strong class="fs-18 text-success">{{ price($data->amount_paid ?? 0) }}</strong></td>
                </tr>
                <tr>
                    <td class="w-15"><span class="fs-18 text-muted">{{ __('Reliquat') }} (Ar) :</span></td>
                    <td><strong class="fs-18 text-danger">{{ price($data->rest ?? 0) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
    <form action="{{ route('mada-agent.facturation.paiement', ['id' => $data->id]) }}" method="POST" class="mt-3">
        @method('put')
        @csrf
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Amount'),
                'name' => 'amount',
                'default' => $default,
                'class' => ['number-only'],
                'rules' => ['required']
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.select', [
                'label' => __('Payment method'),
                'name' => 'method_payment',
                'rules' => ['required'],
                'options' => [
                    'cash' => __('Cash'),
                    'cheque' => __('Cheque'),
                    'bank transfer' => __('Bank transfer'),
                    'credit' => 'Credit',
                    'mvola' => "M'Vola",
                    'orange money' => 'Orange Money',
                    'airtel money' => 'Airtel Money'
                ]
            ])
        </div>
        
        <div class="form-group mb-3">
            @include('elements.textarea', [
                'name' => 'reference_payment',
                'help' => __("Separate with commas if more than one"),
                'label' => __('Reference'),
                'rules' => ['required'],
                'default' => null
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