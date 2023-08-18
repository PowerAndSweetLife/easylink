<div class="modal-header d-flex align-items-center position-sticky bg-white shadow-sm" style="top: 0; z-index: 10">
    <div class="w-100 d-flex justify-content-between align-items-center gap-5">
        <div class="w-100 d-flex justify-content-between">
            <div class="lh-14">
                <p class="m-0 text-center fs-12"><span>{{ __('Manifest') }}</span></p>
                <p class="m-0 text-center text-muted fs-18"><span class="fw-300">{{ $manifest->reference }}</span></p>
            </div>
            <div class="lh-14">
                <p class="m-0 text-center fs-12"><span>{{ __('Container') }}</span></p>
                <p class="m-0 text-center text-muted fs-18"><span class="fw-300">{{ $manifest->container->number }}</span></p>
            </div>
            <div class="lh-14">
                <p class="m-0 text-center fs-12"><span>{{ __('Volume') }}</span></p>
                <p class="m-0 text-center text-muted fs-18"><span class="fw-300">{{ $manifest->volume() }} m³</span></p>
            </div>
        </div>
        <div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    </div>
    {{-- <h1 class="modal-title fs-5" id="package-lists-label">{{ __('Booking n°') }}</h1> --}}
</div>
<div class="modal-body">
    <div class="accordion" id="accordion-list-colis">
        @foreach ($manifest->booking as $k => $booking)
            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button @class(["accordion-button py-2", "collapsed"]) type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $k + 1 }}" aria-expanded="true" aria-controls="collapse-{{ $k + 1 }}">
                        <div class="w-100 pe-5 d-flex justify-content-between">
                            <span>{{ $booking->reference }}</span>
                            <span>{{ $booking->client->uid }}</span>
                            <span>{{ $booking->client->shortName() }}</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse-{{ $k + 1 }}" @class(["accordion-collapse collapse"]) data-bs-parent="#accordion-list-colis">
                    <div class="accordion-body">
                        <div class="table-responsive table-sticky" style="max-height: 55vh">
                            <table class="table table-bordered">
                                <thead class="bg-white">
                                    <tr>
                                        <th scope="col" class=" text-secondary">{{ __('Shiporder') }}</th>
                                        <th scope="col" class=" text-secondary">{{ __('Package number') }}</th>
                                        <th scope="col" class=" text-secondary">{{ __('Courrier company') }}</th>
                                        <th scope="col" class=" text-secondary">{{ __('Number of package') }}</th>
                                        <th scope="col" class=" text-secondary">{{ __('Volume') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking->colis as $colis)
                                        <tr>
                                            <td>{{ $colis->shiporder }}</td>
                                            <td>{{ $colis->receip_number }}</td>
                                            <td>{{ $colis->courrier_company }}</td>
                                            <td>{{ $colis->number() }}</td>
                                            <td>{{ $colis->volume() }} m³</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        <div>
                        <form action="{{ route('agent.manifest.removeBooking', ['id' => $booking->id]) }}" 
                            class="w-100 d-flex justify-content-end" 
                            method="POST" 
                            onsubmit="removeFromDetailList(event, this)">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger">{{ __('Remove from container') }}</button>
                        </form>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>
