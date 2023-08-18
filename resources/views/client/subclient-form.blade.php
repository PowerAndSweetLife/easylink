@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Register a new subclient")}}</h2>

<div class="main-content">
    <ul class="nav nav-underline w-100 mb-4">
        <li class="nav-item">
            <a @class(['nav-link', 'active' => $active === 'entreprise']) href="{{ route('client.subclient.create', ['type' => 'entreprise']) }}">Entreprise</a>
        </li>
        <li class="nav-item">
            <a @class(['nav-link', 'active' => $active === 'particulier']) href="{{ route('client.subclient.create', ['type' => 'particulier']) }}">Particulier</a>
        </li>
    </ul>
    @if (isset($data->id))
        <form action="{{ route('client.subclient.update', $data) }}" method="post">
        @method('put')
    @else
        <form action="{{ route('client.subclient.store') }}" method="post"> 
    @endif
        @csrf
        @if ($active === 'entreprise')
            <input type="hidden" name="type" value="company">
            @include('client.components.subclient-entreprise-form')
        @else
            <input type="hidden" name="type" value="individual">
            @include('client.components.subclient-particulier-form') 
        @endif
        @include('elements.btn-submit', [
            'update' => isset($data->id)
        ])
    </form>
</div>

@endsection