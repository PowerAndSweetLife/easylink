@extends('auth.register')

<input type="hidden" name="type" value="particulier">

@section('content')
    <div class="register-form particulier">
        <div class="form-group mb-3">            
            <div class="row">
                <div class="col-xl-2 col-3">
                    @include('elements.select', [
                        'label' => 'Civilité',
                        'name' => 'civility',
                        'options' => [
                            'Mr.' => 'M.',
                            'Ms.' => 'Mme.'
                        ],
                        'class' => ['text-center'],
                        'default' => $client->civility ?? null
                    ])
                </div>
                <div class="col-xl-10 col-9">
                    @include('elements.input', [
                        'label' => 'Nom',
                        'name' => 'firstname',
                        'rules' => ['required'],
                        'default' => $client->firstname ?? null
                    ])
                </div>
            </div>
        </div>

        <div class="form-group mb-3">            
            @include('elements.input', [
                'label' => 'Prénoms',
                'name' => 'lastname',
                'rules' => ['required'],
                'default' => $client->lastname ?? null
            ])
        </div>
        <div class="form-group mb-3">            
            @include('elements.input', [
                'label' => 'Email',
                'name' => 'email',
                'rules' => ['required', 'email'],
                'default' => $client->email ?? null
            ])
        </div>
        <div class="form-group mb-3">            
            @include('elements.input', [
                'label' => 'Contact',
                'name' => 'contact',
                'rules' => ['required'],
                'default' => $client->contact ?? null
            ])
        </div>
        <div class="form-group mb-3">            
            @include('elements.input', [
                'label' => 'Mot de passe',
                'name' => 'password',
                'rules' => ['required', 'confirm-password'],
                'type' => 'password',
                'default' => $client->password ?? null
            ])
        </div>
        <div class="form-group mb-3">            
            @include('elements.input', [
                'label' => 'Confirmation mot de passe',
                'name' => 'confirm-password',
                'rules' => ['required', 'confirm-password'],
                'type' => 'password',
                'default' => $client->password ?? null
            ])
        </div>

        <div class="form-group mb-4">
            <button class="btn btn-primary w-100">
                <span class="fs-18 fw-300">S'inscrire</span>
            </button>
        </div>

    </div>
@endsection