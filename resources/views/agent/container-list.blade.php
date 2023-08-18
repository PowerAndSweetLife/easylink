@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{ __("List of container") }}</h2>
<ul class="nav nav-underline nav-swipe mb-4">
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'agent.container.create']) href="{{ route('agent.container.create') }}">{{ __("New container") }}</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'agent.container.index']) href="{{ route('agent.container.index') }}">{{ __("List of container") }}</a>
    </li>
</ul>
<div class="main-content">
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">{{ __('Number') }}</th>
                    <th scope="col">{{ __('Type') }}</th>
                    <th scope="col">{{ __('Carrier') }}</th>
                    <th scope="col">{{ __('Vessel voyage') }}</th>
                    <th scope="col">{{ __('Port of load') }}</th>
                    <th scope="col">{{ __('Port of discharge') }}</th>
                    <th scope="col">{{ __('E.T.D') }}</th>
                    <th scope="col">{{ __('Available') }}</th>
                    <th scope="col" class="table-column-action">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $item)
                    <tr>
                        <td>{{ $item->number }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->carrier }}</td>
                        <td>{{ $item->vessel_voyage }}</td>
                        <td>{{ $item->port_of_load }}</td>
                        <td>{{ $item->port_of_discharge }}</td>
                        <td>{{ $item->etd }}</td>
                        <td>
                            @if ($item->is_available)
                                <span class="text-success">{{__("Yes")}}</span>
                            @else
                                <span class="text-danger">{{__("No")}}</span>
                            @endif
                        </td>
                        <td class="table-column-action">
                            @include('elements.dropdown', [
                                'actions' => [
                                    'edit' => ['url' => route('agent.container.edit', ['container' => $item])],
                                    'delete' => ['url' => route('agent.container.destroy', ['container' => $item])]
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