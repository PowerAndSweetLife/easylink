@extends('base')

@section('content')
<h2 class="fs-18 py-2 text-primary">{{ __("Loyalty card") }}</h2>
<div class="main-content">
    <div style="width: max-content">
        <img id="loyalty-card" alt="" width="350px">
        <div class="text-center mt-2">
            <a download="my-card.png" id="download-link" style="font-family: arial;">
                <span class="me-1"><i class="fa-solid fa-download"></i></span>
                {{ __('Download') }}
            </a>
        </div>
    </div>

    <div style="display: none;" class="vip-card">
        <img src="{{ asset('assets/img/blue.jpg') }}" alt="" id="background" style="display: none;">
        <img src="{{ asset('assets/img/logo-easylink.webp') }}" alt="" id="vip-logo" style="display: none;">
        <canvas id="card" width="850" height="500"></canvas>
    </div>
</div>
@endsection

@section('javascript')
<script>
    const background = document.querySelector("#background")
    const title = document.querySelector("#vip-title")
    const logo = document.querySelector("#vip-logo")

    const canvas = document.querySelector("#card")

    const viewer = document.querySelector("#loyalty-card")
    const downloadLink = document.querySelector("#download-link")
    
    setTimeout(() => {
        const ctx = canvas.getContext("2d");

        ctx.drawImage(background, 0, 0, 850, 500);

        ctx.strokeStyle = "#0e5daa";

        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.lineTo(850, 0);
        ctx.moveTo(850, 0);
        ctx.lineTo(850, 500);
        ctx.moveTo(850, 500);
        ctx.lineTo(0, 500);
        ctx.moveTo(0, 500);
        ctx.lineTo(0, 0);
        ctx.stroke();

        ctx.fillStyle = "#0e5daa";
        ctx.drawImage(logo, 600, 20, 200, 80)

        ctx.font = "italic 38px Times-new-roman"
        ctx.fillText("My card", 50, 70);

        ctx.font = "normal 42px Arial"
        ctx.textAlign = "center";
        ctx.fillText("{{ $client->name() }}", 425, 200);
        
        ctx.font = "normal 48px Arial"
        ctx.fillText("{{ $client->uid }}", 425, 265);

        ctx.fillStyle = "white";

        ctx.font = "normal 22px Arial"
        ctx.fillText("www.easygroupage.mg", 720, 470);

        let url = canvas.toDataURL();
        viewer.setAttribute('src', url);
        downloadLink.setAttribute('href', url);
    }, 500)
</script>
@endsection