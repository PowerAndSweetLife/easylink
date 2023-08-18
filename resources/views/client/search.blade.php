@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Search") }}</h2>

<div class="main-content">
    <form action="" method="post">
        @csrf
        <div class="form-group mb-3">
            <label>{{ __('Sending date') }}</label>
            <hr class="mt-1">
            <div class="row">
                <div class="col-md-6">
                    @include('elements.input', [
                        'label' => __('Start'),
                        'name' => 'date-begin',
                        'type' => 'date',
                        'class' => ['date-input']
                    ])
                </div>
                <div class="col-md-6">
                    @include('elements.input', [
                        'label' => __('End'),
                        'name' => 'date-end',
                        'type' => 'date',
                        'class' => ['date-input']
                    ])
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label>{{ __('Reference') }}</label>
            <hr class="mt-1">
            <div class="row">
                <div class="col-md-6">
                    @include('elements.select', [
                        'label' => __('Type'),
                        'name' => 'type',
                        'options' => [
                            'package' => __('Package'),
                            'shiporder' => __('Ship order'),
                            'booking' => __('Booking'),
                            'manifest' => __('Manifest')
                        ]
                    ])
                </div>
                <div class="col-md-6">
                    @include('elements.input', [
                        'label' => __('Reference'),
                        'name' => 'ref',
                        'type' => 'text'
                    ])
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <button class="btn btn-primary btn-submit w-100">
                    <span>{{ __('Search') }}</span>
                    <span><i class="fa-solid fa-magnifying-glass"></i></span>
                </button>
            </div>
        </div>
        
    </form>

    @if ($results)
        <div class="mt-3">
            <h3>{{ __('Search results') }}</h3>
            <div class="accordion" id="accordionExample">
                @foreach ($results as $k => $item)
                  <div class="accordion-item">
                      <div class="accordion-header">
                          <div class="accordion-button py-2 expedition-accordion-header {{ $k > 0 ? 'collapsed' : null }}" role="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $k + 1 }}" aria-expanded="true" aria-controls="collapseOne">
                              <div class="w-100 d-flex justify-content-between pe-4">
                                <div class="d-flex flex-column align-items-center" style="line-height: 14px">
                                  <span class="label fs-12">{{ __("Shiporder") }}</span>
                                  <span class="fw-600">{{ $item->expedition->shiporder }}</span>
                                </div>
                                <div class="d-flex flex-column align-items-center" style="line-height: 14px">
                                  <span class="label fs-12">{{ __("Sending at") }}</span>
                                  <span class="fw-600">{{ shortDate($item->expedition->sending_at) }}</span>
                                </div>
                                <div class="d-flex flex-column align-items-center" style="line-height: 14px">
                                  <span class="label fs-12">{{ __("Received at") }}</span>
                                  <span class="fw-600">{{ shortDate($item->expedition->received_at) }}</span>
                                </div>
                                <div class="d-flex flex-column align-items-center" style="line-height: 14px">
                                  <span class="label fs-12">{{ __("Status") }}</span>
                                  <span class="fw-600">{{ $item->status }}</span>
                                </div>
                              </div>
                          </div>
                      </div>
                      <div id="collapse-{{ $k + 1 }}" class="accordion-collapse collapse {{ $k === 0 ? 'show' : null }}" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                              <div class="receip-list">
                                <table class="w-100 text-start">
                                  <tr>
                                    <td class="w-25">{{ __("Agent name") }}</td>
                                    <td><strong>{{ $item->agent->fullname() }}</strong></td>
                                  </tr>
                                  <tr>
                                    <td class="w-25">{{ __('Agent localization') }}</td>
                                    <td><strong>{{ $item->agent->localization->region }}, {{ $item->agent->localization->country }}</strong></td>
                                  </tr>
                                  <tr>
                                    <td class="w-25">{{ __("Agent adress") }}</td>
                                    <td><span>{{ $item->agent->address }}</span></td>
                                  </tr>
                                </table>
                                
                                <div class="table-responsive table-sticky" style="max-height: 45vh">
                                    <table class="table table-striped">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th scope="col">{{__('Bordereau')}}</th>
                                                <th scope="col">{{__('Package number')}}</th>
                                                <th scope="col">{{__('Catégory')}}</th>
                                                <th scope="col">{{__('Description')}}</th>
                                                <th scope="col">{{__('Volume')}}</th>
                                                <th scope="col">{{__('Weight')}}</th>
                                                <th scope="col">{{__('Courier company')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr>
                                                <td>{{ $item->receip_number }}</td>
                                                <td>{{ $item->number() }}</td>
                                                <td>{{ $item->category->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->volume() }} m³</td>
                                                <td>{{ $item->weight() }} Kg</td>
                                                <td>{{ $item->courrier_company }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
                @endforeach
              </div>
        </div>
    @endif
</div>

@endsection