@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Message")}}</h2>


<div class="main-content">
    <div class="message-wrapper">
        {{-- <p class="text-center">
            <a href="#" class="link-secondary">Message plus ancien</a>
        </p> --}}

        @foreach ($lists->reverse() as $message)
            @if ($message->sender === 'admin')
                <div class="message-content">
                    <p class="d-flex justify-content-between m-0">
                        <span class="m-0">
                            <strong>easylink</strong> | 
                            <span class="text-muted">{{ $message->admin->lastname }}</span></span>
                        <span class="fs-12">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                    </p>
                    <p class="mb-1 fw-300">{{ $message->body }}</p>
                </div>
            @else
                <div class="message-content self">
                    <p class="d-flex justify-content-between m-0">
                        <strong>{{ __('Me') }}</strong>
                        <span class="fs-12">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                    </p>
                    <p class="mb-1 fw-300">{{ $message->body }}</p>
                </div>
            @endif
           
        @endforeach
        {{-- <div class="message-content">
            <p class="d-flex justify-content-between m-0">
                <span class="m-0">
                    <strong>easylink</strong> | 
                    <span class="text-muted">John doe</span></span>
                <span class="fs-12">17/05/2023 08:00</span>
            </p>
            <p class="mb-1 fw-300">Bonjour client</p>
        </div> --}}
    </div>
    <form action="{{ route('client.message.store') }}" method="post" enctype="multipart/form-data" class="mt-2">
        @csrf
        <div class="form-group d-flex gap-2">
            <textarea name="body" class="form-control" rows="1" placeholder="{{ __("Type your message here...") }}"></textarea>
            <button class="btn btn-sm btn-primary py-1">{{ __('Send') }}</button>
        </div>
    </form>
</div>

@endsection