@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Detail packages") }} - N° {{ $colis->receip_number }}</h2>

<div class="main-content">
    <table class="table table-bordered table-text-left">
        <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Description") }}</strong></td>
            <td>
                <div class="d-flex flex-column justify-content-center">
                    @foreach ($colis->description() as $description)
                        <span> - {{ $description }}</span>
                    @endforeach
                </div>
            </td>
        </tr>
        <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Category") }}</strong></td>
            <td>{{ $colis->category->name }}</td>
        </tr>
        <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Courrier company") }}</strong></td>
            <td>{{ $colis->courrier_company }}</td>
        </tr>
        <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Number of package") }}</strong></td>
            <td>{{ $colis->number() }}</td>
        </tr>
        <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Dimensions") }}</strong></td>
            <td>{{ $colis->volume() > 0 ? $colis->volume() . " m³" : '----' }}  | {{ $colis->weight() > 0 ? $colis->weight() . ' kg' : '----'}}</td>
        </tr>
        {{-- <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Size") }}</strong></td>
            <td>{{ $colis->size() }}</td>
        </tr> --}}
        <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Client ID") }}</strong></td>
            <td>{{ $colis->client->uid }}</td>
        </tr>
        <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Client name") }}</strong></td>
            <td>{{ $colis->client->shortName() }}</td>
        </tr>
        <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Sending date") }}</strong></td>
            <td>{{ $colis->sendAt()->format('d/m/Y') }}</td>
        </tr>
        <tr style="vertical-align: middle">
            <td class="w-25 ps-2"><strong>{{ __("Attachments") }}</strong></td>
            <td>
                <div class="d-flex flex-column justify-content-center">
                    @foreach ($colis->attachments() as $attach)
                        <a href="{{ asset('storage/colis_attachments/'. $attach) }}" target="_blank"> - {{ $attach }}</a>
                    @endforeach
                </div>
            </td>
        </tr>
    </table>
    <div class="d-flex w-100 justify-content-end gap-2">
        @if ($colis->booking_id)
            {{-- <form action="{{ route('agent.colis.notReceived') }}" method="post">
                @csrf
                @method('delete')
                <input type="hidden" name="colis-id" value="{{ $colis->id }}">
                <button class="btn btn-danger">
                    <span><i class="fa-regular fa-trash-can"></i></span>
                    <span class="ms-2">{{ __('Mark as not received') }}</span>
                </button>
            </form> --}}
        @else
            <a href="{{ route('agent.colis.edit', ['id' => $colis->id]) }}" class="btn btn-success">{{ __("Edit this package") }}</a>
            <form action="{{ route('agent.colis.receive') }}" method="post">
                @csrf
                @method('put')
                <input type="hidden" name="colis-id" value="{{ $colis->id }}">
                <button class="btn btn-primary">
                    <span><i class="fa-solid fa-hand-holding-hand"></i></span>
                    <span class="ms-2">{{ __('Receive this package') }}</span>
                </button>
            </form>
        @endif
    </div>
</div>

@endsection