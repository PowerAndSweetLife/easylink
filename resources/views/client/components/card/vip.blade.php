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
        <img src="{{ asset('assets/img/black.jpg') }}" alt="" id="background" style="display: none;">
        <img src="{{ asset('assets/img/logo-vip.png') }}" alt="" id="vip-logo" style="display: none;">
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
    const ctx = canvas.getContext("2d");
    
    const viewer = document.querySelector("#loyalty-card")
    const downloadLink = document.querySelector("#download-link")
    

    setTimeout(() => {      
        ctx.drawImage(background, 0, 0, 850, 500);
        ctx.drawImage(logo, 650, 20, 150, 150)

        let agetaNormal = new FontFace("Ageta", `url("{{asset('assets/font/Ageta Chubby Demo.otf')}}")`);
        agetaNormal.load().then(() => {
            
            ctx.fillStyle = "#dbb234";
            ctx.font = "italic 32px Ageta"
            ctx.fillText("My card", 50, 100);
            ctx.font = "normal 42px Ageta"
            ctx.textAlign = "center";
            ctx.fillText("{{ $client->name() }}", 425, 250);

            ctx.font = "normal 42px Arial"
            ctx.textAlign = "center";
            ctx.fillText("{{ $client->cbm }} point(s)", 425, 370);

            ctx.font = "normal 48px Ageta"
            ctx.fillText("{{ $client->uid }}", 425, 320);
                
            ctx.font = "normal 22px Arial"
            ctx.fillStyle = "white";
            ctx.fillText("www.easylink.mg", 700, 470);

            let url = canvas.toDataURL();
            viewer.setAttribute('src', url);
            downloadLink.setAttribute('href', url);

        }).catch( (e) => {
            console.log(e);
        });

        
    }, 500)
</script>
@endsection