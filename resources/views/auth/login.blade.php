<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }} ">
    <title>{{ ucfirst($user) }} | {{ __('Login') }}</title>
</head>
<body>
    @include('elements.svg-alert')
    <div class="wrapper">
        <div class="layout left d-flex justify-content-center align-items-center">
            <h1 class="text-light">Publicité easylink</h1>
        </div>
        <div class="layout right">
            <div class="header">
                @error('loginError')
                    <div class="alert alert-danger d-flex align-items-center w-100" role="alert">
                        <div class="h-100 d-flex pt-1">
                            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        </div>
                        <div>
                            <strong class="fs-14 alert-heading d-flex align-items-center">
                                <span>{{ __('Login failed') }}</span>
                            </strong>
                            <p class="m-0 fs-13">{{ __('Username or password incorrect !') }}</p>
                        </div>
                    </div>
                @enderror
                @if(session('password-modified'))
                    <div class="alert alert-success d-flex align-items-center w-100" role="alert">
                        <div class="h-100 d-flex pt-1">
                            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#info-fill"/></svg>
                        </div>
                        <div>
                            <strong class="fs-14 alert-heading d-flex align-items-center">
                                <span>{{ __('Password changed') }}</span>
                            </strong>
                            <p class="m-0 fs-13">{{ __('Check your email and log in with the new password') }}</p>
                        </div>
                    </div>
                @endif
                <h2 class="fs-22">{{ $label }}</h2>
            </div>
                
            <form action="{{ $action }}" class="auth-form js-form" method="POST" autocomplete="off">
                @csrf
                <div class="form-group mb-3">            
                    @include('elements.input', [
                        'label' => __('Username or email'),
                        'name' => 'username',
                        'rules' => ['required'],
                        'class' => ['form-control-lg']
                    ])
                </div>
                <div class="form-group mb-1">            
                    @include('elements.input', [
                        'label' => __('Password'),
                        'name' => 'password',
                        'rules' => ['required'],
                        'type' => 'password',
                        'class' => ['form-control-lg']
                    ])
                </div>
                <p>
                    <a href="{{ route("$user.forgot-password") }}" class="fw-600 fs-12">{{ __('Forgot password ?') }}</a>
                </p>
                <div class="form-group mb-5">
                    <button class="btn btn-primary btn-lg w-100">
                        <span class="fs-18 fw-300">{{__('Login')}}</span>
                    </button>
                </div>
                @if ($withRegister)
                    <p class="fs-12 text-center">
                        <span>Vous n'avez pas de compte ?</span>
                        <a href="{{ route('client.register', ['type' => 'entreprise']) }}" class="link-dark fw-700 ms-2">S'inscrire</a>
                    </p>
                @endif
            </form>
        </div>
    </div>

    <script src="{{asset('assets/js/ui.js')}}"></script>
    @include('script-utils')
</body>
</html>