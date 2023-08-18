<div class="modal fade" id="booking-modal" tabindex="-1" aria-labelledby="booking-modal-label" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog  modal-xl">
        <form class="modal-content" method="POST">
            @method('put')
            @csrf
            <div class="d-none" id="append-booking-form"></div>


            <div class="modal-header">
                <h1 class="modal-title fs-5" id="booking-modal-label">{{ __("List of container available") }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion vh-65 overflow-y-auto">
                    @forelse($manifests as $i => $manifest)
                        <div class="accordion-item" id="accordion">
                            <div class="accordion-header w-100 d-flex flex-row-reverse">
                                <button class="accordion-button collapsed" 
                                        type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#collapse-<?= $i + 1 ?>" 
                                        aria-expanded="true" 
                                        aria-controls="collapse-<?= $i + 1 ?>"
                                        style="width: 50px">
                                </button>
                                <label onclick="_stopPropagation(event)" class="d-flex align-items-center justify-content-between px-4" style="flex: 1">
                                    <div>
                                        <input type="checkbox" onchange="toggleButtonAddToContainer(this)" class="check-container-available me-2" name="manifest-id" value="{{ $manifest->id }}">
                                        <span class="fs-14">{{ __("Container") }} N°:</span> 
                                        <strong class="ms-2">
                                            {{ $manifest->container->number }}
                                        </strong>
                                    </div>
                                    <div>
                                        <span class="fw-300 fs-12">{{ __('Number of booking') }} :</span>
                                        <span class="ms-2">{{ $manifest->booking->count() }}</span>
                                    </div>
                                    <div>
                                        <span class="fs-18 fw-300">{{ $manifest->volume() }} m³</span>
                                    </div>
                                </label>
                            </div>
                            <div id="collapse-<?= $i + 1 ?>" class="accordion-collapse collapse mb-0" data-bs-parent="#accordion">
                                <div class="accordion-body">      
                                    <table class="table table-text-left">
                                        <tr class="w-100" style="vertical-align: top">
                                            <td class="w-50">{{ __('Type') }}</td>
                                            <td class="w-50 fw-600">{{ $manifest->container->type }}</td>
                                        </tr>
                                        <tr class="w-100" style="vertical-align: top">
                                            <td class="w-50">{{ __('Vessel voyage') }}</td>
                                            <td class="w-50 fw-600">{{ $manifest->container->vessel_voyage }}</td>
                                        </tr>
                                        <tr class="w-100" style="vertical-align: top">
                                            <td class="w-50">{{ __('Carrier') }}</td>
                                            <td class="w-50 fw-600">{{ $manifest->container->carrier }}</td>
                                        </tr>
                                        <tr class="w-100" style="vertical-align: top">
                                            <td class="w-50">{{ __('Port of load') }}</td>
                                            <td class="w-50 fw-600">{{ $manifest->container->port_of_load }}</td>
                                        </tr>
                                        <tr class="w-100" style="vertical-align: top">
                                            <td class="w-50">{{ __('Port of discharge') }}</td>
                                            <td class="w-50 fw-600">{{ $manifest->container->port_of_discharge }}</td>
                                        </tr>
                                        <tr class="w-100" style="vertical-align: top">
                                            <td class="w-50">{{ __('Estimated time of departure') }}</td>
                                            <td class="w-50 fw-600">{{ $manifest->container->etd()->format('d/m/Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
                    @empty
                        <div class="vh-65 d-flex justify-content-center align-items-center flex-column">
                            <p class="m-0 fs-22 fw-300">{{ __('No container available') }}</p>
                            <p class="m-0">
                                <a href="{{ route('agent.container.create') }}">
                                    <span><i class="fa-solid fa-add"></i></span>
                                    <span class="ms-1">{{ __('Add new container') }}</span>
                                </a>
                            </p>
                        </div>
                    @endforelse
                </div>
                @if (!$manifests->isEmpty())
                    <div class="modal-footer d-flex justify-content-between">
                        <a href="{{ route('agent.container.create') }}">
                            <span><i class="fa-solid fa-add"></i></span>
                            <span class="ms-1">{{ __('Add new container') }}</span>
                        </a>
                        <button type="submit" class="btn btn-primary" disabled id="btn-submit-adding-to-container">
                            <span class="ms-2"><i class="fa-solid fa-anchor-circle-check"></i></span>
                            {{ __("Choose container") }}
                        </button>
                    </div>
                @endif
                
            </div>
        </form>
    </div>
</div>