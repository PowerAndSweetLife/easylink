@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Package delivery")}}</h2>


<div class="main-content">
    
    <div action="" class="mb-2">
        <div class="row">
            <div class="col-md-7">
                <form class="d-none" id="form-for-checkbox" action="{{ route('mada-agent.livraison.more') }}" method="POST">
                    @csrf
                    @method('put')
                    <button class="btn btn-danger">
                        {{ __("Mark as delivered") }}
                        <span class="badge bg-primary ms-2" id="checked-count"></span>
                    </button>
                </form>
            </div>
            <form class="col-md-5 d-flex">
                <div style="flex: 1">
                @include('elements.input', [
                    'name' => 'uid',
                    'label' => 'Client ID',
                    'default' => $uid ?? null,
                ])
                </div>
                <div>
                    <label class="d-block w-100" style="height: 1.15rem"></label>
                    <button class="btn btn-success" style="padding: .45rem 2rem">{{ __('Filter') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive table-sticky" style="height: 75vh">
        <table class="table table-striped">
            <thead>
                <tr>
                    @if (count($lists))
                        <th scope="col" style="width: 20px"><input type="checkbox" id="check-all"></th>
                    @endif
                    <th scope="col">{{__('Client ID')}}</th>
                    <th scope="col">{{__('Client name')}}</th>
                    <th scope="col">{{__('Package number')}}</th>
                    <th scope="col">{{__('Sending date')}}</th>
                    <th scope="col" class="table-column-action">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($lists as $item)
                <tr>
                    @if (count($lists))
                        <td><input type="checkbox" class="check-item" name="id-list[]" value="{{ $item->id }}"></td>
                    @endif
                    <td>{{ $item->client->uid }}</td>
                    <td>{{ $item->client->shortName() }}</td>
                    <td>{{ $item->receip_number }}</td>
                    <td>{{ shortDate($item->send_at) }}</td>
                    <td class="table-column-action">
                        <div class="dropdown">
                            <span class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-sliders"></i>
                            </span>
                            <ul class="dropdown-menu">
                                <li>
                                    <form action="{{ route('mada-agent.livraison.single', ['id' => $item->id]) }}" method="POST" class="dropdown-item">
                                        @csrf
                                        @method('put')
                                        <button class="dropdown-btn btn-with-confirm">
                                            <span class="me-2"><i class="fa-solid fa-clipboard-check"></i></span>
                                            {{ __('Mark as delivered') }}
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('mada-agent.livraison.show', ['id' => $item->id]) }}" onclick="openDetailModal(event, this)">
                                        <span><i class="fa-solid fa-info-circle"></i></span>
                                        <span class="ms-2">{{ __('Detail') }}</span>
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

    {{ $lists->links() }}
</div>

@include('mada-agent.modal.package-lists')

@endsection