@php
    $classLists = ["form-control"];
    if(isset($class))
    {
        $classLists = array_merge($class, $classLists);
    }
    $required = false;
    if(isset($rules) && in_array("required", $rules))
    {
        $required = true;
    }

    $attributes = [];
    if(isset($attr))
    {
        $attributes = array_merge($attributes, $attr);
    }
@endphp

@error($name)
    @php
        $classLists[] = "is-invalid";
    @endphp
@enderror


<div class="lh-14 mb-1">
    <label @class(["fs-13 fw-700", "required" => $required === true])>{{ $label ?? null }}</label>
    @if (isset($help))   
        <p class="m-0">
            <small class="help fs-11 text-muted">{{ $help }}</small>
        </p>
    @endif
</div>
<input 
    type="{{ $type ?? 'text' }}"
    class="{{ join(" ", $classLists) }}"
    data-rules="@php echo join(',', ($rules ?? [])) @endphp"
    name="{{ $name }}"
    value="{{ old($name, $default ?? null) }}"
    @error($name) autofocus @enderror
    autocomplete="off"
    {{ join(' ', $attributes) }}
>
@error($name)
    <span class="invalid-feedback">{{ $message }}</span>
@enderror