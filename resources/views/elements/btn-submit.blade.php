<div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-4">
        @if (isset($update) && $update === true)
            <button class="btn btn-success btn-submit w-100">
                <span>{{ __('Update') }}</span>
                <span><i class="fa-solid fa-check"></i></span>
            </button>
        @else
            <button class="btn btn-primary btn-submit w-100">
                <span>{{ __('Save') }}</span>
                <span><i class="fa-solid fa-check"></i></span>
            </button>
        @endif
    </div>
</div>