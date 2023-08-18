

@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Booking list") }} - {{ $manifest->reference }} - {{ $manifest->container->number }}</h2>

<div class="main-content">
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">{{ __('Reference') }}</th>
                    <th scope="col">{{ __('Client ID') }}</th>
                    <th scope="col">{{ __('Client name') }}</th>
                    <th scope="col" class="text-center">{{ __('Number of shiporder') }}</th>
                    <th scope="col" class="text-center">{{ __('Volume') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $item)
                    <tr>
                        <td>{{ $item->reference }}</td>
                        <td>{{ $item->client->uid }}</td>
                        <td>{{ $item->client->shortName() }}</td>
                        <td class="text-center d-flex align-items-center justify-content-center">
                            <span class="link-to-more">
                                <span>
                                    <p class="m-0 fs-600">{{ $item->colis->count() }}</p>
                                    <p class="m-0">
                                        <a href="{{ route('admin.booking.show', ['id' => $item->id]) }}" onclick="openDetailModal(event, this)">{{ __('Detail') }}</a>
                                    </p>
                                </span>
                            </span>
                        </td>
                        <td class="text-center">{{ $item->volume() }} m³</td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    
    <div class="paginator mt-4">
        {{ $lists->links() }}
    </div>
</div>


@include('mada-agent.modal.package-lists')

@endsection
