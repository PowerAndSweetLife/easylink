
  <div class="accordion" id="accordionExample">
    @foreach ($lists as $k => $item)
      <div class="accordion-item">
          <div class="accordion-header">
              <div class="accordion-button py-2 expedition-accordion-header {{ $k > 0 ? 'collapsed' : null }}" role="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $k + 1 }}" aria-expanded="true" aria-controls="collapseOne">
                  <div class="d-flex justify-content-between pe-4 w-100">
                      <div class="d-flex flex-column align-items-center" style="line-height: 14px">
                        <span class="label fs-12">{{ __("Bordereau") }}</span>
                        <span class="fw-600">{{ $item->receip_number }}</span>
                      </div>
                      <div class="d-flex flex-column align-items-center" style="line-height: 14px">
                        <span class="label fs-12">{{ __("Sending at") }}</span>
                        <span class="fw-600">{{ shortDate($item->send_at) }}</span>
                      </div>
                  </div>
              </div>
          </div>
          <div id="collapse-{{ $k + 1 }}" class="accordion-collapse collapse {{ $k === 0 ? 'show' : null }}" data-bs-parent="#accordionExample">
              <div class="accordion-body">
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
                      <tr>
                        <td class="w-25">{{ __("Volume") }}</td>
                        <td><strong>{{ $item->volume() }} m³</strong></td>
                      </tr>
                      <tr>
                        <td class="w-25">{{ __("Weight") }}</td>
                        <td><strong>{{ $item->weight() }} kg</strong></td>
                      </tr>
                    </table>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <form action="{{ route('client.colis.destroy', ['coli' => $item]) }}" method="post" class="d-inline-block">
                          @method('delete')
                          @csrf
                          <button class="btn btn-sm btn-danger btn-with-confirm">
                            <span class="me-1"><i class="fa-regular fa-trash-can"></i></span>
                            {{ __('Delete') }}
                          </button>
                        </form>
                        <a href="{{ route('client.colis.edit', ['coli' => $item]) }}" class="btn btn-sm btn-success" style="min-width: 120px">
                          <span class="me-1"><i class="fa-regular fa-pen-to-square"></i></span>
                          {{ __('Edit') }}
                        </a>
                    </div>
                  </div>
              </div>
          </div>
      </div>
    @endforeach
  </div>