@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Sub-clients list")}}</h2>


<div class="main-content">

    <p>
        <a href="{{ route('client.subclient.create') }}" class="btn btn-primary">Add new subclient</a>
    </p>

    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('Contact')}}</th>
                    <th scope="col">{{__('Email')}}</th>
                    <th scope="col">{{__('NIF')}}</th>
                    <th scope="col">{{__('STAT')}}</th>
                    <th scope="col">{{__('RCS')}}</th>
                    <th scope="col" class="table-column-action">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($lists as $item)
                <tr>
                    <td>{{ $item->longName() }}</td>
                    <td>{{ $item->contact }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->nif }}</td>
                    <td>{{ $item->stat }}</td>
                    <td>{{ $item->rcs }}</td>
                    <td class="table-column-action">
                        @include('elements.dropdown', [
                            'actions' => [
                                'edit' => ['url' => route('client.subclient.edit', ['subclient' => $item])],
                                'delete' => ['url' => route('client.subclient.destroy', ['subclient' => $item])]
                            ] 
                        ])
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- {{ $lists->links() }} --}}
</div>

@endsection