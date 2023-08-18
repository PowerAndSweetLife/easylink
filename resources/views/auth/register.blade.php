<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('assets/css/auth.css')}}">
    <title>Client | Inscription</title>
</head>
<body>
    <div class="wrapper register">
        <div class="layout left d-flex justify-content-center align-items-center">
            <h1 class="text-light">Publicité easylink</h1>
        </div>
        <div class="layout right">
            <div class="header">
                <h2 class="fs-22">S'incrire</h2>
            </div>
            <form action="{{ route('client.register.'. $active) }}" class="auth-form js-form mt-2" method="post" enctype="multipart/form-data">
                @csrf
                <ul class="nav nav-underline w-100 mb-4">
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => $active === 'entreprise']) href="{{ route('client.register', ['type' => 'entreprise']) }}">Entreprise</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => $active === 'particulier']) href="{{ route('client.register', ['type' => 'particulier']) }}">Particulier</a>
                    </li>
                </ul>

                @yield('content')
                

                <p class="fs-12 text-center">
                    <span>Vous avez une compte ?</span>
                    <a href="{{ route('client.login') }}" class="link-dark fw-700 ms-2">Se connecter</a>
                </p>
            </form>
        </div>
    </div>

    <script src="{{asset('assets/js/ui.js')}}"></script>
    @include('script-utils')
</body>
</html>