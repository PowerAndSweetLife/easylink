@extends('base')

@section('content')


<h2 class="fs-18 py-2 text-primary">
    {{__("Edit a facture")}} - {{ $data->booking->reference }}
</h2>

<div class="main-content">
    <form action="{{ route('admin.facturation.update', ['id' => $data->id]) }}" method="POST">
        @method('put')
        @csrf
        <div class="accordion" id="accordionExample">
            @php
                $iterator = 1;
            @endphp
            @foreach ($data->booking->expedition->all() as $expedition)

                @foreach ($expedition->colis()->get() as $colis)
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div 
                                class="accordion-button py-2 {{ $iterator > 1 ? 'collapsed' : null }}" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse-{{ $iterator }}" 
                                aria-expanded="true" 
                                aria-controls="collapseOne">
                                <div class="w-100 d-flex justify-content-between pe-4">
                                    <strong class="fs-20">{{ $colis->receip }}</strong>
                                    <span>{{ __('Bordereau') }} : {{$colis->receip_number}}</span>
                                    <span>{{ $colis->volume() }} m³</span>
                                </div>
                            </div>
                        </div>
                        <div id="collapse-{{ $iterator }}" class="accordion-collapse collapse {{ $iterator === 1 ? 'show' : null }}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <input type="hidden" name="id[]" value="{{ $colis->id }}">
                                <div class="form-group mb-3">
                                    @include('elements.select', [
                                        "label" => __('Catégory'),
                                        "name" => "categories[$colis->id]",
                                        "options" => $categories->pluck('name', 'id'),
                                        "required" => true,
                                        "default" => $colis->category_id
                                    ])
                                </div>
                                <div class="form-group mb-3">
                                    @include("elements.input-dimension", [
                                        'label' => __('Dimensions'),
                                        "default" => $colis->dimensions(),
                                        "id" => $colis->id
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $iterator++;
                    @endphp
                @endforeach
                
            @endforeach
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-primary" style="min-width: 25%">{{__('Generate')}}</button>
        </div>
    </form>
</div>
@endsection