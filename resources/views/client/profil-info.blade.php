@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Profile")}}</h2>
<ul class="nav nav-underline nav-swipe mb-4">
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'client.profil.index']) href="{{ route('client.profil.index') }}">{{ __("Edit information") }}</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'client.profil.password']) href="{{ route('client.profil.password') }}">{{ __("Change password") }}</a>
    </li>
</ul>
<div class="main-content">
    <form method="POST" action="{{ route('client.profil.updateInfo.' . $data->type, ['client' => $data]) }}">
    @method('put')
    @csrf
    <input type="hidden" name="password" value="fake-password">
    <input type="hidden" name="confirm-password" value="fake-password">
    @if ($data->type === 'company')
        <div class="form-group mb-3">            
            @include('elements.input', [
                'label' => 'Raison social',
                'name' => 'company_name',
                'rules' => ['required'],
                'default' => $data->company_name ?? null
            ])
        </div>
        <div class="form-group mb-3">            
            <div class="row">
                <div class="col-6 pe-1">
                    @include('elements.input', [
                        'label' => 'NIF',
                        'name' => 'nif',
                        'rules' => ['required'],
                        'default' => $data->nif ?? null
                    ])
                </div>
                <div class="col-6 ps-1">
                    @include('elements.input', [
                        'label' => 'STAT',
                        'name' => 'stat',
                        'rules' => ['required'],
                        'default' => $data->stat ?? null
                    ])
                </div>
            </div>
        </div>
        <div class="form-group mb-3">            
            <div class="row">
                <div class="col-6 pe-1">
                    @include('elements.input', [
                        'label' => 'RCS',
                        'name' => 'rcs',
                        'rules' => ['required'],
                        'default' => $data->rcs ?? null
                    ])
                </div>
                <div class="col-6 ps-1">
                    @include('elements.input', [
                        'label' => 'Contact',
                        'name' => 'contact',
                        'rules' => ['required'],
                        'default' => $data->contact ?? null
                    ])
                </div>
            </div>
        </div>
        <div class="form-group mb-3">            
            @include('elements.input', [
                'label' => 'Email',
                'name' => 'email',
                'rules' => ['required', 'email'],
                'default' => $data->email ?? null
            ])
        </div>
    @else  
    <div class="form-group mb-3">            
        <div class="row">
            <div class="col-xl-2 col-3">
                @include('elements.select', [
                    'label' => 'Civilité',
                    'name' => 'civility',
                    'options' => [
                        'Mr.' => 'M.',
                        'Ms.' => 'Mme.'
                    ],
                    'class' => ['text-center'],
                    'default' => $data->civility ?? null
                ])
            </div>
            <div class="col-xl-10 col-9">
                @include('elements.input', [
                    'label' => 'Nom',
                    'name' => 'firstname',
                    'rules' => ['required'],
                    'default' => $data->firstname ?? null
                ])
            </div>
        </div>
    </div>

    <div class="form-group mb-3">            
        @include('elements.input', [
            'label' => 'Prénoms',
            'name' => 'lastname',
            'rules' => ['required'],
            'default' => $data->lastname ?? null
        ])
    </div>
    <div class="form-group mb-3">            
        @include('elements.input', [
            'label' => 'Email',
            'name' => 'email',
            'rules' => ['required', 'email'],
            'default' => $data->email ?? null
        ])
    </div>
    <div class="form-group mb-3">            
        @include('elements.input', [
            'label' => 'Contact',
            'name' => 'contact',
            'rules' => ['required'],
            'default' => $data->contact ?? null
        ])
    </div>
    @endif
            
    @include('elements.btn-submit', [
        'update' => true
    ])
    </form>
</div>

@endsection