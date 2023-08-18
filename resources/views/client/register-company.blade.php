@extends('auth.register')
<input type="hidden" name="type" value="company">

@section('content')

    <div class="register-form entreprise">
        <div class="form-group mb-3">            
            @include('elements.input', [
                'label' => 'Raison social',
                'name' => 'company_name',
                'rules' => ['required'],
                'default' => $client->company_name ?? null
            ])
        </div>
        <div class="form-group mb-3">            
            <div class="row">
                <div class="col-6 pe-1">
                    @include('elements.input', [
                        'label' => 'NIF',
                        'name' => 'nif',
                        'rules' => ['required'],
                        'default' => $client->nif ?? null
                    ])
                </div>
                <div class="col-6 ps-1">
                    @include('elements.input', [
                        'label' => 'STAT',
                        'name' => 'stat',
                        'rules' => ['required'],
                        'default' => $client->stat ?? null
                    ])
                </div>
            </div>
        </div>
        <div class="form-group mb-3">            
            <div class="row">
                <div class="col-6 pe-1">
                    @include('elements.input', [
                        'label' => 'RCS',
                        'name' => 'rcs',
                        'rules' => ['required'],
                        'default' => $client->rcs ?? null
                    ])
                </div>
                <div class="col-6 ps-1">
                    @include('elements.input', [
                        'label' => 'Contact',
                        'name' => 'contact',
                        'rules' => ['required'],
                        'default' => $client->contact ?? null
                    ])
                </div>
            </div>
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
            <div class="row">
                <div class="col-6 pe-1">
                    @include('elements.input', [
                        'label' => 'Mot de passe',
                        'name' => 'password',
                        'rules' => ['required', 'confirm-password'],
                        'type' => 'password',
                        'default' => $client->password ?? null
                    ])
                </div>
                <div class="col-6 ps-1">
                    @include('elements.input', [
                        'label' => 'Confirmation mot de passe',
                        'name' => 'confirm-password',
                        'rules' => ['required', 'confirm-password'],
                        'type' => 'password',
                        'default' => $client->password ?? null
                    ])
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <label class="fs-13 fw-700">Carte CIF</label>
            <input type="file" class="form-control" is="drop-files" name="cif" accept=".png,.jpg,.jpeg,.pdf">
        </div>
        <div class="form-group mb-4">
            <button class="btn btn-primary w-100">
                <span class="fs-18 fw-300">S'inscrire</span>
            </button>
        </div>
    </div>
    
@endsection