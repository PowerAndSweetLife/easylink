@extends('base')

@section('content')
<h2 class="fs-18 py-2 text-primary">{{ __("Slip sheet") }}</h2>
<div class="new-expedition-layout">
    <div class="left py-2 shadow-sm">
        {{-- <h5 class="px-4 title">{{__("Slip sheet")}}</h5> --}}
        @if (isset($data->id))
            <form action="{{ route('client.colis.update', ['coli' => $data]) }}" method="POST" class="px-4" enctype="multipart/form-data">
                @method('put')
        @else
            <form action="{{ route('client.colis.store') }}" method="POST" class="px-4" enctype="multipart/form-data">
        @endif
            @csrf
            <div class="form-group mb-3">
                @include('elements.input', [
                    'name' => 'receip_number',
                    'label' => __('Slip number'),
                    'rules' => ['required'],
                    'default' => $data->receip_number ?? null
                ])
            </div>
            <div class="form-group mb-3">
                @include('elements.input', [
                    'name' => 'courrier_company',
                    'label' => __('Courrier company'),
                    'rules' => ['required'],
                    'default' => $data->courrier_company ?? null
                ])
            </div>
            
            <div class="form-group mb-3">
                @include('elements.select', [
                    'name' => 'category_id',
                    'label' => __('Category'),
                    'rules' => ['required'],
                    'default' => $data->category_id ?? null,
                    'options' => $categories->pluck('name', 'id')->all()
                ])
            </div>
            <div class="form-group mb-3">
                @include('elements.textarea', [
                    'name' => 'description',
                    'help' => __("Separate with commas if more than one"),
                    'label' => __('Real description'),
                    'rules' => ['required'],
                    'default' => $data->description ?? null
                ])
            </div>
            <div class="form-group mb-3">
                @include('elements.select', [
                    'name' => 'agent_id',
                    'label' => __('Agent name'),
                    'rules' => ['required'],
                    'options' => $agents->pluck('lastname', 'id'),
                    'default' => $data->agent_id
                ])
            </div>
            <div class="form-group mb-3">
                @include('elements.input-dimension', [
                    'label' => __('Dimensions'),
                    'default' => isset($data->dimensions) ? $data->dimensions() : null,
                ])
            </div>
            {{-- <div class="form-group mb-3">
                @include('elements.select', [
                    'name' => 'subclient_id',
                    'label' => __('Subclient'),
                    'rules' => [],
                    'default' => $data->subclient_id ?? null,
                    'class' => ['ui', 'search', 'dropdown'],
                    'options' => $subclients,
                    'defaultOption' => __("Select a subclient")
                ])
            </div> --}}
            <div class="form-group mb-3">
                <label class="fs-13 fw-700">{{ __("Attachments") }}</label>
                <input type="file" class="form-control" multiple is="drop-files" name="attachments[]" label="{{__('Drop files here or click to upload')}}">
            </div>
            @include('elements.btn-submit', [
                'update' => isset($data->id)
            ])
        </form>
    </div>
    {{-- <div class="right py-2 shadow-sm">
        <h5 class="px-4 title">Listes à envoyer</h5>
        <div action="" class="px-4 form js-form">
            <div class="accordion" id="accordion-colis-list">
                @foreach($colisList as $i => $colis)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $i + 1 }}" aria-expanded="true" aria-controls="collapse-<?= $i + 1 ?>">
                            <span class="fs-14">{{ __("Bordereau") }} N°:</span> <strong class="ms-2">{{ $colis->receip_number }}</strong>
                        </button>
                        </h2>
                        <div id="collapse-{{ $i + 1 }}" class="accordion-collapse collapse mb-0" data-bs-parent="#accordion-colis-list">
                            <div class="accordion-body">
                                <table>
                                    <tr class="w-100" style="vertical-align: top">
                                        <td class="w-50">{{ __('Courrier company') }}</td>
                                        <td class="w-50 fw-600">{{ $colis->courrier_company }}</td>
                                    </tr>
                                    <tr class="w-100" style="vertical-align: top">
                                        <td class="w-50">{{ __('Category') }}</td>
                                        <td class="w-50 fw-600">{{ $colis->category->name }}</td>
                                    </tr>
                                    <tr class="w-100" style="vertical-align: top">
                                        <td class="w-50">{{ __('Description') }}</td>
                                        <td class="w-50 fw-600">{{ $colis->description }}</td>
                                    </tr>
                                    <tr class="w-100" style="vertical-align: top">
                                        <td class="w-50">{{ __('Dimension') }}</td>
                                        <td class="w-50 fw-600">{{ $colis->volume() }} m³</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="d-flex gap-2 py-2 px-4">
                                <form class="w-50" action="{{ route('client.colis.destroy', ['coli' => $colis]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-danger w-100">{{ __('Delete') }}</button>
                                </form>
                                <a href="{{ route('client.colis.edit', ['coli' => $colis]) }}" class="w-50 btn btn-sm btn-success">{{ __('Edit') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if (count($colisList))
                <form action="{{ route('client.expedition.store') }}" method="POST">
                    @csrf
                    @foreach ($colisList as $colis)
                        <input type="hidden" name="colis-id[]" value="{{ $colis->id }}">
                    @endforeach
                    <div class="mt-3">
                        @include('elements.select', [
                            'label' => __("Select an agent"),
                            'name' => "agent_id",
                            'rules' => ["required"],
                            'options' => $agents->pluck('lastname', 'id'),
                            'defaultOption' => null
                        ])
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary w-100">{{ __("Send") }}</button>
                    </div>
                </form>
            @endif
        </div>
    </div> --}}
</div>
@endsection