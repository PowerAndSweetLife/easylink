@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Clients list")}}</h2>


<div class="main-content">

    <div class="row mb-3">
        <div class="col-md-6"></div>
        <form action="" class="col-md-6 d-flex">
            <input type="search" name="query" value="{{ $query ?? null }}" class="form-control">
            <button class="btn btn-primary">{{ __('Search') }}</button>
        </form>
    </div>
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped table-text-left">
            <thead>
                <tr>
                    <th scope="col">{{__('UID')}}</th>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('Contact')}}</th>
                    <th scope="col">{{__('Email')}}</th>
                    <th scope="col">{{__('NIF')}}</th>
                    <th scope="col">{{__('STAT')}}</th>
                    <th scope="col">{{__('RCS')}}</th>
                    <th scope="col">{{__('CIF')}}</th>
                    <th scope="col">{{__('Total CBM')}}</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($lists as $item)
                <tr>
                    <td>{{ $item->uid }}</td>
                    <td>{{ $item->longName() }}</td>
                    <td>{{ $item->contact }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->nif }}</td>
                    <td>{{ $item->stat }}</td>
                    <td>{{ $item->rcs }}</td>
                    <td><a href="{{ asset('storage/cif/' . $item->cif) }}" target="_blank">{{ $item->cif }}</a></td>
                    <td>{{ $item->cbm }}  m³</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $lists->links() }}
</div>

@endsection