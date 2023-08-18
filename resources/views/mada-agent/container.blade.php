@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("List of container") }}</h2>
<div class="main-content">
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">{{ __('Manifest') }}</th>
                    <th scope="col">{{ __('Container number') }}</th>
                    <th scope="col">{{ __('Vessel voyage') }}</th>
                    <th scope="col">{{ __('Number of booking') }}</th>
                    <th scope="col">{{ __('Volume') }}</th>
                    <th scope="col">{{ __('Poids') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col" class="table-column-action">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $item)
                    <tr>
                        <td>{{ $item->reference }}</td>
                        <td>{{ $item->container->number }}</td>
                        <td>{{ $item->container->vessel_voyage }}</td>
                        <td class="text-center d-flex align-items-center justify-content-center">
                            <span class="link-to-more">
                                <span>
                                    <p class="m-0 fs-600">{{ $item->booking->count() }}</p>
                                    <p class="m-0">
                                        <a href="{{ route('mada-agent.container.booking.list', ['id' => $item->id]) }}">{{ __('Detail') }}</a>
                                    </p>
                                </span>
                            </span>
                        </td>
                        <td>{{ $item->volume() }} m³</td>
                        <td>{{ App\Helper\Dimension::weightStr($item->weight()) }}</td>
                        <td>{{ __($item->status) }}</td>
                        <td class="table-column-action">
                            <div class="dropdown">
                                <span class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-sliders"></i>
                                </span>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('mada-agent.container.editDate', ['id' => $item->id]) }}">
                                            <span><i class="fa-solid fa-calendar-days"></i></span>
                                            <span class="ms-2">{{ __('Edit date') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('mada-agent.container.editStatus', ['id' => $item->id]) }}">
                                            <span><i class="fa-regular fa-pen-to-square"></i></span>
                                            <span class="ms-2">{{ __('Change status') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('mada-agent.container.editPrice', ['id' => $item->id]) }}">
                                            <span><i class="fa-solid fa-coins"></i></span>
                                            <span class="ms-2">{{ __('Edit price') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                            
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    <div class="paginator">
        {{ $lists->links() }}
    </div>
</div>

@endsection