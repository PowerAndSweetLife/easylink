@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Add new container") }}</h2>
<ul class="nav nav-underline nav-swipe mb-4">
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'agent.container.create']) href="{{ route('agent.container.create') }}">{{ __("New container") }}</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'agent.container.index']) href="{{ route('agent.container.index') }}">{{ __("List of container") }}</a>
    </li>
</ul>
<div class="main-content">
    @if (isset($data->id))   
        <form action="{{ route('agent.container.update', ['container' => $data]) }}" method="post"> 
            @method('put')
    @else 
        <form action="{{ route('agent.container.store') }}" method="post">
    @endif
        @csrf
        <div class="form-group mb-3">
            @include('elements.input',[
                'label' => __("Container number"),
                'name' => 'number',
                'rules' => ['required'],
                'default' => $data->number ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.select',[
                'label' => __("Container type"),
                'name' => 'type',
                'rules' => ['required'],
                'options' => ["20'" => "20'", "40'" => "40'"],
                'default' => $data->type ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input',[
                'label' => __("Carrier"),
                'name' => 'carrier',
                'rules' => ['required'],
                'default' => $data->carrier ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input',[
                'label' => __("Vessel voyage"),
                'name' => 'vessel_voyage',
                'rules' => ['required'],
                'default' => $data->vessel_voyage ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input',[
                'label' => __("Port of load"),
                'name' => 'port_of_load',
                'rules' => ['required'],
                'default' => $data->port_of_load ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input',[
                'label' => __("Port of discharge"),
                'name' => 'port_of_discharge',
                'rules' => ['required'],
                'default' => $data->port_of_discharge ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input',[
                'label' => __("Estimated time of departure"),
                'name' => 'etd',
                'rules' => ['required'],
                'default' => isset($data) ? $data->etd()->format('Y-m-d') : null,
                'type' => 'date',
                'class' => ['date-input']
            ])
        </div>
        @include('elements.btn-submit', [
            'update' => isset($data->id)
        ])
    </form>
</div>

@endsection