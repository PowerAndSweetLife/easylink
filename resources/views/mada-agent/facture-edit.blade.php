@extends('base')

@section('content')


<h2 class="fs-18 py-2 text-primary">
    {{__("Edit a facture")}} - {{ $data->booking->reference }}
</h2>

<div class="main-content">
    <form action="{{ route('mada-agent.facturation.update', ['id' => $data->id]) }}" method="POST">
        @method('put')
        @csrf
        <div class="accordion" id="accordionExample">
                @foreach ($data->booking->colis as $k => $colis)
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div 
                                class="accordion-button py-2 {{ $k > 0 ? 'collapsed' : null }}" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse-{{ $k }}" 
                                aria-expanded="true" 
                                aria-controls="collapseOne">
                                <div class="w-100 d-flex justify-content-between pe-4">
                                    <span>{{ __('Bordereau') }} : {{$colis->receip_number}}</span>
                                    <span>{{ $colis->volume() }} m³</span>
                                </div>
                            </div>
                        </div>
                        <div id="collapse-{{ $k }}" class="accordion-collapse collapse {{ $k === 0 ? 'show' : null }}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <input type="hidden" name="id[]" value="{{ $colis->id }}">
                                <div class="form-group mb-3">
                                    @include('elements.select', [
                                        "label" => __('Category'),
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
                @endforeach
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-primary" style="min-width: 25%">{{__('Generate')}}</button>
        </div>
    </form>
</div>
@endsection