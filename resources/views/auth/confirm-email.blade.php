<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('assets/css/auth.css')}}">
    <title>Client | Confirmation</title>
</head>
<body>
    <div class="wrapper">
        <div class="layout left d-flex justify-content-center align-items-center">
            <h1 class="text-light">Publicité easylink</h1>
        </div>
        <div class="layout right">
            <div class="header">
                <h2 class="fs-22">Confirmation adresse email</h2>
                <p class="text-center fs-14 m-0">Consultez votre boite email et saisissez le code de confirmation</p>
            </div>
            <form action="" class="auth-form js-form" method="post">
                @csrf
                <div class="form-group mb-1">            
                    @include('elements.input', [
                        'label' => 'Code de confirmation',
                        'name' => 'code',
                        'rules' => ['required'],
                        'class' => ['form-control-lg'],
                        'default' => in_array(env('APP_ENV'), ['local', 'dev']) ? $client->email_confirmation_code : null
                    ])
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="m-0">
                        <span class="fs-14 text-muted">Votre email:</span>
                        <a target="_blank" href="mailto:{{ $client->email }}" class="link-secondary fw-300">{{$client->email}}</a>
                    </p>
                    <a href="{{ route('client.change-email') }}" class="fs-14 link-success">Modifier</a>
                </div>
                
                <div class="form-group mb-3">     
                    <div class="mt-3">
                        <p class="fs-12 m-0 text-center">
                            Vous n'avez pas reçu le code ? 
                            <a href="{{ route('client.regenerate-code') }}" class="fs-14 link-success">Nouveau code</a>
                        </p>
                    </div>
                </div>

                <div class="form-group mb-5">
                    <button class="btn btn-primary btn-lg w-100">
                        <span class="fs-18 fw-300">Verifier</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{asset('assets/js/ui.js')}}"></script>
    @include('script-utils')
</body>
</html>