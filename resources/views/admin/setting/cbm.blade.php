@extends('base')

@section('content')

@include('admin.setting.header')


<div class="main-content">
    <form action="{{ route('admin.setting.updateCbm') }}" method="POST">
            @method('put')
        @csrf
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('CBM Min.'),
                'help' => __('Price in Ariary'),
                'name' => 'cbm_min',
                'rules' => ['required'],
                'class' => ['number-only'],
                'default' => $data->value
            ])
        </div>
        @include('elements.btn-submit', [
            'update' => true
        ])
    </form>

    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th scope="col">{{ __('Last update') }}</th>
                <th scope="col">{{ __('Updated by') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ shortDate($data->updated_at) }}</td>
                <td>{{ $data->admin->lastname ?? __('System') }}</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection