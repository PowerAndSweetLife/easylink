<div class="modal-header d-flex align-items-center position-sticky bg-white shadow-sm" style="top: 0; z-index: 10">
    <div class="w-100 d-flex justify-content-between align-items-center">
        <div class="lh-14">
            <p class="m-0 text-center fs-12"><span>{{ __('Booking') }}</span></p>
            <p class="m-0 text-center text-muted fs-18"><strong>{{ $booking->reference }}</strong></p>
        </div>
        <div class="lh-14">
            <p class="m-0 text-center fs-12"><span>{{ __('Client') }}</span></p>
            <p class="m-0 text-center text-muted fs-18"><strong>{{ $booking->client->uid }}</strong></p>
        </div>
        <div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    </div>
    {{-- <h1 class="modal-title fs-5" id="package-lists-label">{{ __('Booking n°') }}</h1> --}}
</div>
<div class="modal-body">
    <div class="accordion" id="accordion-list-colis">
        @foreach ($booking->colis as $k => $colis)
            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button @class(["accordion-button fs-14", "collapsed"]) type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $k + 1 }}" aria-expanded="true" aria-controls="collapse-{{ $k + 1 }}">
                        {{ $colis->shiporder }}
                    </button>
                </h2>
                <div id="collapse-{{ $k + 1 }}" @class(["accordion-collapse collapse"]) data-bs-parent="#accordion-list-colis">
                    <div class="accordion-body">
                        <table class="table table-text-left">
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
                        
                        @if ($colis->status == 'send')
                            <form action="{{ route('agent.booking.removeColis', ['id' => $colis->id]) }}" 
                                class="w-100 d-flex justify-content-end" 
                                method="POST" 
                                onsubmit="removeFromDetailList(event, this)">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger">{{ __('Remove from booking') }}</button>
                            </form>
                        @endif
                        
                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}