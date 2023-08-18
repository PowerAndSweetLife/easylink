@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Profile")}}</h2>
<ul class="nav nav-underline nav-swipe mb-4">
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'admin.profil.index']) href="{{ route('admin.profil.index') }}">{{ __("Edit information") }}</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'admin.profil.password']) href="{{ route('admin.profil.password') }}">{{ __("Change password") }}</a>
    </li>
</ul>
<div class="main-content">
    <form method="POST" action="{{ route('admin.profil.updatePassword', ['admin' => $data]) }}">
        @method('put')

        @csrf
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('New Password'),
                'name' => 'password',
                'rules' => ['required'],
                'type' => 'password'
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Confirm Password'),
                'name' => 'confirm-password',
                'rules' => ['required'],
                'type' => 'password'
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Your Password'),
                'name' => 'current-password',
                'rules' => ['required'],
                'type' => 'password'
            ])
        </div>
        
        @include('elements.btn-submit', [
            'update' => true
        ])
    </form>
</div>

@endsection