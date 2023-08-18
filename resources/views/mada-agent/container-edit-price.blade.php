@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">
    {{__("Edit a container")}} - {{ $data->container->number }}
    <p class="fs-16 m-0 text-secondary">
        Manifest: {{ $data->reference }}
    </p>
</h2>

<div class="main-content">
    <form action="{{ route('mada-agent.container.updatePrice', ['id' => $data->id]) }}" method="POST">
        @method('put')
        @csrf
        <div class="form-group mb-3">
            @include('elements.select', [
                'label' => __('Exchange unit'),
                'name' => 'unit',
                'default' => $data->unit ?? null,
                'options' => $units->pluck('name', 'alias')
            ])
        </div>
        
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('BMOI Rate'),
                'name' => 'bmoi_rate',
                'default' => $data->bmoi_rate ??  null
            ])
        </div>
        
        @include('elements.btn-submit', [
            'update' => true
        ])
    </form>
</div>
@endsection