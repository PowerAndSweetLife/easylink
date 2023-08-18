@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Manage agents")}}</h2>

<ul class="nav nav-underline nav-swipe mb-4">
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $active === 'chine']) href="{{ route('admin.agent.index', ['pays' => 'chine']) }}">{{ __("Agent in china") }}</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $active === 'mada']) href="{{ route('admin.agent.index', ['pays' => 'mada']) }}">{{ __("Agent in Madagascar") }}</a>
    </li>
</ul>

@php
    $routeNamePrefix = "agent";
    $paramName = "agent";
    if($active === 'mada')
    {
        $routeNamePrefix = 'mada-agent';
        $paramName = "mada_agent";
    }
@endphp

<div class="main-content">
    @if (isset($data->id))
        <form action="{{ route("admin.$routeNamePrefix.update", [$paramName => $data]) }}" method="POST">
            @method('put')
    @else
        <form action="{{ route("admin.$routeNamePrefix.store") }}" method="POST">
    @endif
        @csrf
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Username'),
                'name' => 'username',
                'rules' => ['required'],
                'default' => $data->username ?? null
            ])
        </div>
        <div class="form-group row mb-3">
            <div class="col-md-6">
                @include('elements.input', [
                    'label' => __('Firstname'),
                    'name' => 'firstname',
                    'rules' => ['required'],
                    'default' => $data->firstname ?? null
                ])
            </div>
            <div class="col-md-6">
                @include('elements.input', [
                    'label' => __('Lastname'),
                    'name' => 'lastname',
                    'rules' => ['required'],
                    'default' => $data->lastname ?? null
                ])
            </div>
        </div>
        <div class="form-group row mb-3">
            <div class="col-md-6">
                @include('elements.input', [
                    'label' => __('Email'),
                    'name' => 'email',
                    'rules' => ['required'],
                    'default' => $data->email ?? null
                ])
            </div>
            <div class="col-md-6">
                @include('elements.input', [
                    'label' => __('Contact'),
                    'name' => 'contact',
                    'rules' => ['required'],
                    'default' => $data->contact ?? null
                ])
            </div>
        </div>

        @if ($active === 'chine')
            <div class="form-group mb-3">
                @include('elements.input', [
                    'label' => __('Phone number'),
                    'name' => 'phone',
                    'rules' => ['required'],
                    'default' => $data->phone ?? null
                ])
            </div>
            <div class="form-group mb-3">
                @include('elements.select', [
                    'label' => __('Localization'),
                    'name' => 'localization_id',
                    'rules' => ['required'],
                    'default' => $data->localization->id ?? null,
                    'options' => $localizations->pluck("region","id")->all()
                ])
            </div>
            
            <div class="form-group mb-3">
                @include('elements.textarea', [
                    'label' => __('Address small parcel'),
                    'name' => 'address-small',
                    'rules' => ['required'],
                    'default' => $data->address('small') ?? null
                ])
            </div>

            <div class="form-group mb-3">
                @include('elements.textarea', [
                    'label' => __('Address regular parcel'),
                    'name' => 'address-regular',
                    'rules' => ['required'],
                    'default' => $data->address('regular') ?? null
                ])
            </div>
        @endif
        
        @include('elements.btn-submit', [
            'update' => isset($data->id)
        ])
    </form>

    <div class="table-responsive table-sticky table-category mt-5">
        <table class="table table-striped table-text-left">
            <thead>
                <tr>
                    <th scope="col">{{__('Username')}}</th>
                    <th scope="col">{{__('Fullname')}}</th>
                    <th scope="col">{{__('Contact')}}</th>
                    <th scope="col">{{__('Email')}}</th>
                    @if ($active === 'chine')
                        <th scope="col">{{__('Localization')}}</th>
                        <th scope="col">{{__('Address')}}</th>
                    @endif
                    <th scope="col" class="table-column-action">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($lists as $item)
                <tr>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->firstname }} {{ $item->lastname }}</td>
                    <td>{{ $item->contact }}</td>
                    <td>{{ $item->email }}</td>
                    @if ($active === 'chine')
                        <td>{{ $item->localization->region }}</td>
                        <td>
                            <ol class="px-3 mb-0">
                                <li>{{ $item->address('small') }}</li>
                                <li>{{ $item->address('regular') }}</li>
                            </ol>
                        </td>
                    @endif
                    <td class="table-column-action">
                        @include('elements.dropdown', [
                            'actions' => [
                                'edit' => ['url' => route("admin.$routeNamePrefix.edit", [$paramName => $item])],
                                'delete' => ['url' => route("admin.$routeNamePrefix.destroy", [$paramName => $item])]
                            ] 
                        ])
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginator mt-4">
        {{ $lists->links() }}
    </div>
</div>
@endsection