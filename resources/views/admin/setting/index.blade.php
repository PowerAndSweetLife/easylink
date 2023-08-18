@extends('base')

@section('content')

@include('admin.setting.header')

<div class="main-content">
    @if (isset($data->id))
        <form action="{{ route('admin.category.update', ['category' => $data]) }}" method="POST">
            @method('put')
    @else
        <form action="{{ route('admin.category.store') }}" method="POST">
    @endif
        @csrf
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Category name'),
                'name' => 'name',
                'rules' => ['required'],
                'default' => $data->name ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Price / CBM'),
                'name' => 'price',
                'rules' => ['required'],
                'class' => ['number-only'],
                'default' => $data->price ?? null
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
                    <th scope="col">{{__('Category name')}}</th>
                    <th scope="col">{{__('Price / CBM')}}</th>
                    <th scope="col">{{__('Last update')}}</th>
                    <th scope="col">{{__('Updated by')}}</th>
                    <th scope="col" class="table-column-action">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($lists as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ shortDate($item->updated_at) }}</td>
                    <td>{{ $item->admin->lastname ?? __('System') }}</td>
                    <td class="table-column-action">
                        @include('elements.dropdown', [
                            'actions' => [
                                'edit' => ['url' => route('admin.category.edit', ['category' => $item])],
                                'delete' => ['url' => route('admin.category.destroy', ['category' => $item])]
                            ] 
                        ])
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 paginator">
        {{ $lists->links() }}
    </div>
</div>

@endsection