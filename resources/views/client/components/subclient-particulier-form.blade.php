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
                    'default' => $data->civility ?? null
                ])
            </div>
            <div class="col-xl-10 col-9">
                @include('elements.input', [
                    'label' => 'Nom',
                    'name' => 'firstname',
                    'rules' => ['required'],
                    'default' => $data->firstname ?? null
                ])
            </div>
        </div>
    </div>

    <div class="form-group mb-3">            
        @include('elements.input', [
            'label' => 'Prénoms',
            'name' => 'lastname',
            'rules' => ['required'],
            'default' => $data->lastname ?? null
        ])
    </div>
    <div class="form-group mb-3">            
        @include('elements.input', [
            'label' => 'Email',
            'name' => 'email',
            'rules' => ['required', 'email'],
            'default' => $data->email ?? null
        ])
    </div>
    <div class="form-group mb-3">            
        @include('elements.input', [
            'label' => 'Contact',
            'name' => 'contact',
            'rules' => ['required'],
            'default' => $data->contact ?? null
        ])
    </div>

</div>