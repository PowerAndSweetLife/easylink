@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Manage admin")}}</h2>
<div class="main-content">
    @if (isset($data->id))
        <form action="{{ route('admin.admin.update', ['admin' => $data]) }}" method="POST">
            @method('put')
    @else
        <form action="{{ route('admin.admin.store') }}" method="POST">
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
        
        
        @include('elements.btn-submit', [
            'update' => isset($data->id)
        ])
    </form>

    <div class="table-responsive table-sticky table-category mt-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">{{__('Username')}}</th>
                    <th scope="col">{{__('Fullname')}}</th>
                    <th scope="col">{{__('Contact')}}</th>
                    <th scope="col">{{__('Email')}}</th>
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
                    <td class="table-column-action">
                        @include('elements.dropdown', [
                            'actions' => [
                                'edit' => ['url' => route('admin.admin.edit', ['admin' => $item])],
                                'delete' => ['url' => route('admin.admin.destroy', ['admin' => $item])]
                            ] 
                        ])
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection