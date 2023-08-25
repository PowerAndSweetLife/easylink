@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">
    {{__("Edit a container")}} - {{ $data->container->number }}
    <p class="fs-16 m-0 text-secondary">
        Manifest: {{ $data->reference }}
    </p>
</h2>

<div class="main-content">
    <form action="{{ route('mada-agent.container.updateDate', ['id' => $data->id]) }}" method="POST">
        @method('put')
        @csrf
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('ETA'),
                'name' => 'eta',
                'default' => $data->eta()?->format('Y-m-d') ?? null,
                'type' => 'date',
                'class' => ['date-input'],
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('ATA'),
                'name' => 'ata',
                'default' => $data->ata()?->format('Y-m-d') ?? null,
                'type' => 'date',
                'class' => ['date-input'],
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('DEL'),
                'name' => 'del',
                'default' => $data->del()?->format('Y-m-d') ?? null,
                'type' => 'date',
                'class' => ['date-input'],
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Freetime'),
                'name' => 'freetime',
                'default' => $data->freetime ?? null,
                'type' => 'text',
                'class' => ['integer-only'],
            ])
        </div>

        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('PIC'),
                'name' => '',
                'default' => $data->pic()?->format('Y-m-d') ?? null,
                'type' => 'date',
                'class' => ['date-input'],
                'attr' => ['disabled']
            ])
        </div>

        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('FOC'),
                'name' => '',
                'default' => $data->foc()?->format('Y-m-d') ?? null,
                'type' => 'date',
                'class' => ['date-input'],
                'attr' => ['disabled']
            ])
        </div>

        @if ($allNotNull ==  false)
            @include('elements.btn-submit', [
                'update' => true,
                'withConfirm' => false
            ])
        @else
            @include('elements.btn-submit', [
                    'update' => false ,
                    'withConfirm' => true
                ])
        @endif
    </form>
</div>
@endsection