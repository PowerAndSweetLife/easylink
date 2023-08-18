@php
    $classLists = ["form-control"];
    if(isset($class))
    {
        $classLists = array_merge($class, $classLists);
    }
    $selected = old($name, $default ?? null);
    $required = false;
    if(isset($rules) && in_array("required", $rules))
    {
        $required = true;
    }
@endphp

@error($name)
    @php
        $classLists[] = "is-invalid";
    @endphp
@enderror

<div class=" lh-14 mb-1">
    <label @class(["fs-13 fw-700", "required" => $required === true])>{{ $label ?? null }}</label>
    @if (isset($help))   
        <p class="m-0">
            <small class="help fs-11 text-muted">{{ $help }}</small>
        </p>
    @endif
</div>
<select class="{{ join(" ", $classLists) }}" name="{{ $name }}">
    @if (isset($defaultOption) && $defaultOption !== null)
        <option value="">{{ $defaultOption }}</option>
    @endif
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" {{ $selected === $value ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select>