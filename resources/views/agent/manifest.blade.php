@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("Manifest list") }}</h2>

<div class="main-content">
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">{{ __('Reference') }}</th>
                    <th scope="col">{{ __('Container number') }}</th>
                    <th scope="col">{{ __('Carrier') }}</th>
                    <th scope="col">{{ __('Vessel voyage') }}</th>
                    <th scope="col">{{ __('E.T.D') }}</th>
                    <th scope="col" class="text-center">{{ __('Number of booking') }}</th>
                    <th scope="col" class="text-center">{{ __('Volume') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col" class="table-column-action">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $item)
                    <tr>
                        <td>{{ $item->reference }}</td>
                        <td>{{ $item->container->number }}</td>
                        <td>{{ $item->container->carrier }}</td>
                        <td>{{ $item->container->vessel_voyage }}</td>
                        <td>{{ $item->container->etd()->format('d/m/Y') }}</td>
                        <td class="text-center d-flex align-items-center justify-content-center">
                            <span class="link-to-more">
                                <span>
                                    <p class="m-0 fs-600">{{ $item->booking->count() }}</p>
                                    <p class="m-0">
                                        <a href="{{ route('agent.manifest.show', ['id' => $item->id]) }}" onclick="openDetailModal(event, this)">{{ __('Detail') }}</a>
                                    </p>
                                </span>
                            </span>
                        </td>
                        <td class="text-center">{{ $item->volume() }} m³</td>
                        <td>{{ $item->status }}</td>
                        <td class="table-column-action">
                            <span class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-sliders"></i>
                            </span>
                            <ul class="dropdown-menu">
                                <li>
                                    <form action="{{ route('agent.manifest.send') }}" class="dropdown-item" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="container-id" value="{{ $item->container->id }}">
                                        <button class="dropdown-btn btn-with-confirm">
                                            <span><i class="fa-solid fa-anchor-lock"></i></span>
                                            <span class="ms-2">{{ __('Send') }}</span>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <a href="{{ route('agent.manifest.show', ['id' => $item->id]) }}" class="dropdown-item" onclick="openDetailModal(event, this)">
                                        <span><i class="fa-solid fa-circle-info"></i></span>
                                        <span class="ms-2">{{ __('Detail') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>

@include('agent.modal.booking-lists')

@endsection

@section('javascript')
    <script src="{{ asset('assets/js/agent.js') }}"></script>
@endsection