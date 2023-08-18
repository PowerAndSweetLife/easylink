@extends('base')

@section('content')

@include('admin.setting.header')


<div class="main-content">
    @if (isset($data->id))
        <form action="{{ route('admin.unit.update', ['unit' => $data]) }}" method="POST">
            @method('put')
    @else
        <form action="{{ route('admin.unit.store') }}" method="POST">
    @endif
        @csrf
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Unit name'),
                'name' => 'name',
                'rules' => ['required'],
                'default' => $data->name ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Alias'),
                'name' => 'alias',
                'rules' => ['required'],
                'default' => $data->alias ?? null
            ])
        </div>
        @include('elements.btn-submit', [
            'update' => isset($data->id)
        ])
    </form>

    <div class="table-responsive table-sticky table-category mt-5">
        <table class="table table-striped table-text-left">
            <thead>
                <tr>
                    <th scope="col">{{__('Unit name')}}</th>
                    <th scope="col">{{__('Alias')}}</th>
                    <th scope="col">{{__('Last update')}}</th>
                    <th scope="col">{{__('Updated by')}}</th>
                    <th scope="col" class="table-column-action">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($lists as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->alias }}</td>
                    <td>{{ shortDate($item->updated_at) }}</td>
                    <td>{{ $item->admin->lastname ?? __('System') }}</td>
                    <td class="table-column-action">
                        @include('elements.dropdown', [
                            'actions' => [
                                'edit' => ['url' => route('admin.unit.edit', ['unit' => $item])],
                                'delete' => ['url' => route('admin.unit.destroy', ['unit' => $item])]
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