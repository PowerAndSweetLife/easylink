
<label class="fs-13 fw-700">{{ $label }}</label>

<div class="input-dimension" id="input-dimension">
    @if (isset($default) && is_array($default) && count($default) > 0)   
        @foreach ($default as $k => $item)
            @php
                $name = "dimensions[1][]";
                if(isset($id))
                {
                    $name = "dimensions[$id][1][]";
                }
            @endphp
            <div class="input-dimension-item mb-2">
                <div class="form-floating">
                    <input type="text" name="{{ $name }}" value="{{ $item->count }}" class="form-control number-only dimension-js" placeholder="1">
                    <label  class="fs-12">{{ __('Count') }}</label>
                </div>
                <div class="form-floating">
                    <input type="text" name="{{ $name }}" value="{{ $item->length }}" class="form-control number-only dimension-js" placeholder="1">
                    <label  class="fs-12">{{ __('Length') }}(cm)</label>
                </div>
                <div class="form-floating">
                    <input type="text" name="{{ $name }}" value="{{ $item->width }}" class="form-control number-only dimension-js" placeholder="1">
                    <label  class="fs-12">{{ __('Width') }}(cm)</label>
                </div>
                <div class="form-floating">
                    <input type="text" name="{{$name}}" value="{{ $item->height }}" class="form-control number-only dimension-js" placeholder="1">
                    <label  class="fs-12">{{ __('Height') }}(cm)</label>
                </div>
                <div class="form-floating">
                    <input type="text" name="{{ $name }}" value="{{ $item->weight }}" class="form-control number-only" placeholder="1">
                    <label  class="fs-12">{{ __("Unit weight") }}(kg)</label>
                </div>
                <div class="form-floating">
                    <input 
                        type="text" 
                        name="{{ $name }}" 
                        value="{{ App\Helper\Dimension::volumeStr($item) }}" 
                        class="form-control number-only total-volume-item" 
                        readonly 
                        placeholder="1">
                    <label  class="fs-12">{{ __("Volume") }}</label>
                </div>
            </div>
        @endforeach
    @else
            @php
                $name = "dimensions[1][]";
                if(isset($id))
                {
                    $name = "dimensions[$id][1][]";
                }
            @endphp
        <div class="input-dimension-item">

            <div class="form-floating">
                <input type="text" name="{{ $name }}" class="form-control number-only dimension-js" placeholder="1">
                <label  class="fs-12">{{ __('Count') }}</label>
            </div>
            <div class="form-floating">
                <input type="text" name="{{ $name }}" class="form-control number-only dimension-js" placeholder="1">
                <label  class="fs-12">{{ __('Length') }}(cm)</label>
            </div>
            <div class="form-floating">
                <input type="text" name="{{ $name }}" class="form-control number-only dimension-js" placeholder="1">
                <label  class="fs-12">{{ __('Width') }}(cm)</label>
            </div>
            <div class="form-floating">
                <input type="text" name="{{ $name }}" class="form-control number-only dimension-js" placeholder="1">
                <label  class="fs-12">{{ __('Height') }}(cm)</label>
            </div>
            <div class="form-floating">
                <input type="text" name="{{ $name }}" class="form-control number-only" placeholder="1">
                <label  class="fs-12">{{ __("Weight") }}(kg)</label>
            </div>
            <div class="form-floating">
                <input type="text" name="{{ $name }}" value="" class="form-control number-only total-volume-item" readonly placeholder="1">
                <label  class="fs-12">{{ __("Volume") }}(kg)</label>
            </div>
        </div>
    @endif
    
</div>
<p class="mb-0 mt-1 text-end">
    <span class="me-5 {{ App\Helper\Dimension::hasVolume($default ?? []) ? '' : 'd-none' }}" id="sum-all-volume">
        <span>{{ __('Total volume') }} :</span>
        <strong class="text-success">{{ App\Helper\Dimension::volumesStr($default ?? []) }}</strong>
    </span>
    <span role="button" class="text-danger fs-12" id="remove-dimension">{{ __("Delete") }}</span>
    <span role="button" class="text-primary fs-12 ms-2" id="add-dimension">{{ __("Add") }}</span>
</p>