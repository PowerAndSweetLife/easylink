<div class="modal-header d-flex align-items-center position-sticky bg-white shadow-sm" style="top: 0; z-index: 10">
    <div class="w-100 d-flex justify-content-between align-items-center">
        <h2 class="fs-18 py-2 text-primary">{{ __("Detail packages") }} - N° {{ $colis->receip_number }}</h2>
    </div>
    {{-- <h1 class="modal-title fs-5" id="package-lists-label">{{ __('Booking n°') }}</h1> --}}
</div>
<div class="modal-body">
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
            <td class="w-25 ps-2"><strong>{{ __("Categorie") }}</strong></td>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <form action="{{ route('mada-agent.livraison.single', ['id' => $colis->id]) }}" method="POST">
            @csrf
            @method('put')
            <button class="btn btn-primary btn-with-confirm">
                {{ __('Mark as delivered') }}
            </button>
        </form>
    </div>
</div>

