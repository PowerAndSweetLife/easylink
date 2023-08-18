@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Facturation history") }}</h2>
<div class="main-content">
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th scope="col">{{ __("Paiement date") }}</th>
                    <th scope="col">{{ __("Amount to paid") }}</th>
                    <th scope="col">{{ __("Acompte") }}</th>
                    <th scope="col">{{ __("Reliquat") }}</th>
                    <th scope="col">{{ __("Method payment") }}</th>
                    <th scope="col">{{ __("Reference") }}</th>
                    <th scope="col">{{ __("Action") }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lists as $item)
                    <tr>
                        <td>{{ $item->datePaiement()->format('d/m/Y') }}</td>
                        <td>{{ price($item->to_paid) }}</td>
                        <td>{{ price($item->paid) }}</td>
                        <td>{{ price($item->rest) }}</td>
                        <td>{{ __(ucfirst($item->method_payment)) }}</td>
                        <td>{{ $item->reference_payment }}</td>
                        <td>
                            <a href="{{ route('admin.facturation.print', ['id' => $item->id]) }}" class="btn btn-sm btn-primary" target="_blank">
                                <i class="fa-solid fa-print"></i>
                                <span>{{ __('Print') }}</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection