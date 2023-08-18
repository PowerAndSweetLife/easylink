@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Edit packages") }} - N° {{ $colis->receip_number }}</h2>

<div class="main-content">
    <form method="post" action="{{ route('agent.colis.update', ['id' => $colis->id]) }}">
        @csrf
        @method('put')
        <div class="form-group mb-3">
            @include('elements.select', [
                'name' => 'category_id',
                'label' => __("Category"),
                'options' => $categories->pluck('name', 'id'),
                'default' => $colis->category_id
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.textarea', [
                'name' => 'description',
                'help' => __("Separate with commas if more than one"),
                'label' => __('Real description'),
                'default' => $colis->description ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input-dimension', [
                'label' => __('Dimensions'),
                'default' => $colis->dimensions()
            ])
        </div>
        <div class="w-100 d-flex justify-content-end gap-2">
            <a class="btn btn-secondary" href="{{ route('agent.colis.show', ['id' => $colis->id]) }}">{{ __('Cancel') }}</a>
            <button class="btn btn-success">{{ __('Save and receive') }}</button>
        </div>
    </form>
</div>

@endsection