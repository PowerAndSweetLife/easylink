@extends('base')

@section('content')

@include('admin.setting.header')


<div class="main-content">
    @if (isset($data->id))
        <form action="{{ route('admin.localization.update', ['localization' => $data]) }}" method="POST">
            @method('put')
    @else
        <form action="{{ route('admin.localization.store') }}" method="POST">
    @endif
        @csrf
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Region'),
                'name' => 'region',
                'rules' => ['required'],
                'default' => $data->region ?? null
            ])
        </div>
        <div class="form-group mb-3">
            @include('elements.input', [
                'label' => __('Country'),
                'name' => 'country',
                'rules' => ['required'],
                'default' => $data->country ?? null
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
                    <th scope="col">{{__('Region')}}</th>
                    <th scope="col">{{__('Country')}}</th>
                    <th scope="col">{{__('Last update')}}</th>
                    <th scope="col">{{__('Updated by')}}</th>
                    <th scope="col" class="table-column-action">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($lists as $item)
                <tr>
                    <td>{{ $item->region }}</td>
                    <td>{{ $item->country }}</td>
                    <td>{{ shortDate($item->updated_at) }}</td>
                    <td>{{ $item->admin->lastname ?? __('System') }}</td>
                    <td class="table-column-action">
                        @include('elements.dropdown', [
                            'actions' => [
                                'edit' => ['url' => route('admin.localization.edit', ['localization' => $item])],
                                'delete' => ['url' => route('admin.localization.destroy', ['localization' => $item])]
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