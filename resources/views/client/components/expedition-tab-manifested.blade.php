
<div class="accordion" id="accordionExample">
  @foreach ($lists as $k => $item)
  <template id="event-template-{{$k}}">
    <table class="table table-text-left">
      <tr>
        <td>{{ __('Estimated Time of Arrival') }}</td>
        <td>{{ shortDate($item->manifest->eta) }}</td>
      </tr>
      <tr>
        <td>{{ __('Actual Time of Arrival') }}</td>
        <td>{{ shortDate($item->manifest->ata) }}</td>
      </tr>
      <tr>
        <td>{{ __('Pick Up date') }}</td>
        <td>{{ shortDate($item->manifest->pic) }}</td>
      </tr>
      <tr>
        <td>{{ __('Delivery') }}</td>
        <td>{{ shortDate($item->manifest->del) }}</td>
      </tr>
    </table>
  </template>
    <div class="accordion-item">
        <div class="accordion-header">
            <div class="accordion-button py-3 expedition-accordion-header {{ $k > 0 ? 'collapsed' : null }}" role="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $k + 1 }}" aria-expanded="true" aria-controls="collapseOne">
                <div class="d-flex justify-content-between pe-4 w-100">
                    <div class="d-flex align-items-center" style="line-height: 14px">
                      <span class="label fs-12">{{ __("Booking") }} :</span>
                      <span class="fw-400 ms-2">{{ $item->reference }}</span>
                    </div>
                    <div class="d-flex align-items-center" style="line-height: 14px">
                      <span class="label fs-12">{{ __("Manifest") }} :</span>
                      <span class="fw-400 ms-2">{{ $item->manifest->reference }}</span>
                    </div>
                    <div class="d-flex align-items-center" style="line-height: 14px">
                      <span class="label fs-12">{{ __("Status") }} :</span>
                      <span class="fw-400 ms-2">{{ __($item->manifest->status) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="collapse-{{ $k + 1 }}" class="accordion-collapse collapse {{ $k === 0 ? 'show' : null }}" data-bs-parent="#accordionExample">
            <div class="accordion-body bg-light">
                <div class="receip-list">
                  <div class="d-flex justify-content-end mb-2">
                    <button onclick="showEvent(this)" data-target="#event-template-{{$k}}" class="btn btn-sm btn-warning">{{ __('View event') }}</button>
                  </div>
                  <div class="table-responsive table-sticky vh-60">
                    <table class="w-100 text-start table table-bordered table-text-left">
                      <thead class="bg-primary">
                        <tr>
                          <th scope="col">{{ __('Shiporder') }}</th>
                          <th scope="col">{{ __('Package number') }}</th>
                          <th scope="col">{{ __('Category') }}</th>
                          <th scope="col">{{ __('Description') }}</th>
                          <th scope="col">{{ __('Courrier company') }}</th>
                          <th scope="col" class="text-center">{{ __('Number of package') }}</th>
                          <th scope="col" class="text-center">{{ __('Volume') }}</th>
                          <th scope="col" class="text-center">{{ __('Poids') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($item->colisToShip as $colis)
                          <tr>
                            <td>{{ $colis->shiporder }}</td>
                            <td>{{ $colis->receip_number }}</td>
                            <td>{{ $colis->category->name }}</td>
                            <td>{{ $colis->description }}</td>
                            <td>{{ $colis->courrier_company }}</td>
                            <td class="text-center">{{ $colis->number() }}</td>
                            <td class="text-center">{{ $colis->volume() }} m³</td>
                            <td class="text-center">{{ $colis->weight() }} kg</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
  @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="event-date-modal" tabindex="-1" aria-labelledby="event-date-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="event-date-modal-label">{{ __('Event date') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
      </div>
    </div>
  </div>
</div>