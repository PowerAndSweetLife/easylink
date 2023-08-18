@extends('base')

@section('content')

<h2 class="fs-18 py-2 text-primary">{{__("Message")}}</h2>


<div class="main-content">
    <div class="message-wrapper" style="height: 75vh">
        @foreach ($lists as $message)
            <a class="d-block message-content text-secondary self" href="{{ route('admin.message.show', ['message' => $message]) }}">
                <p class="d-flex justify-content-between m-0">
                    <span class="m-0">
                        <strong>{{ $message->client->uid }}</strong> | 
                        <span class="text-muted">{{ $message->client->shortName() }}</span></span>
                    <span class="fs-12">{{ $message->created_at }}</span>
                </p>
                <p class="mb-1 fw-300">{{ $message->message }}</p>
            </a>
        @endforeach
    </div>
</div>

@endsection