@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">
    {{__("Edit a container")}} - {{ $data->container->number }}
    <p class="fs-16 m-0 text-secondary">
        Manifest: {{ $data->reference }}
    </p>
</h2>

<div class="main-content">
    <form action="{{ route('admin.container.updateStatus', ['id' => $data->id]) }}" method="POST">
        @method('put')
        @csrf
        <div class="form-group mb-3">
            @include('elements.select', [
                'label' => __('Status'),
                'name' => 'status',
                'default' => $data->status ?? null,
                'options' => $status
            ])
        </div>
        
        @include('elements.btn-submit', [
            'update' => true
        ])
    </form>
</div>
@endsection