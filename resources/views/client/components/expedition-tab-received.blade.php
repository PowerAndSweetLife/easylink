
<div class="accordion" id="accordionExample">
  @foreach ($lists as $k => $item)
    <div class="accordion-item">
        <div class="accordion-header">
            <div class="accordion-button py-3 expedition-accordion-header {{ $k > 0 ? 'collapsed' : null }}" role="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $k + 1 }}" aria-expanded="true" aria-controls="collapseOne">
                <div class="d-flex justify-content-between pe-4 w-100">
                    <div class="d-flex align-items-center" style="line-height: 14px">
                      <span class="label fs-12">{{ __("Shiporder") }} :</span>
                      <span class="fw-400 ms-2">{{ $item->shiporder }}</span>
                    </div>
                    <div class="d-flex align-items-center" style="line-height: 14px">
                      <span class="label fs-12">{{ __("Bordereau") }} :</span>
                      <span class="fw-400 ms-2">{{ $item->receip_number }}</span>
                    </div>
                    <div class="d-flex align-items-center" style="line-height: 14px">
                      <span class="label fs-12">{{ __("Received at") }} :</span>
                      <span class="fw-400 ms-2">{{ shortDate($item->receive_at) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="collapse-{{ $k + 1 }}" class="accordion-collapse collapse {{ $k === 0 ? 'show' : null }}" data-bs-parent="#accordionExample">
            <div class="accordion-body bg-light">
                <div class="receip-list">

                  <table class="w-100 text-start table table-bordered table-text-left">
                    <tr>
                      <td class="w-25">{{ __("Category") }}</td>
                      <td><strong>{{ $item->category->name }}</strong></td>
                    </tr>
                    <tr>
                      <td class="w-25">{{ __("Description") }}</td>
                      <td><strong>{{ $item->description }}</strong></td>
                    </tr>
                    <tr>
                      <td class="w-25">{{ __("Courrier company") }}</td>
                      <td><strong>{{ $item->courrier_company }}</strong></td>
                    </tr>
                    <tr>
                      <td class="w-25">{{ __("Number of parcels") }}</td>
                      <td><strong>{{ $item->number() }}</strong></td>
                    </tr>
                      <td class="w-25">{{ __("Volume") }}</td>
                      <td><strong>{{ $item->volume() }} m³</strong></td>
                    </tr>
                    <tr>
                      <td class="w-25">{{ __("Weight") }}</td>
                      <td><strong>{{ $item->weight() }} kg</strong></td>
                    </tr>
                  </table>
                </div>
            </div>
        </div>
    </div>
  @endforeach
</div>