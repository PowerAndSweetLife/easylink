<div class="register-form entreprise">
    <div class="form-group mb-3">            
        @include('elements.input', [
            'label' => 'Raison social',
            'name' => 'company_name',
            'rules' => ['required'],
            'default' => $data->company_name ?? null
        ])
    </div>
    <div class="form-group mb-3">            
        <div class="row">
            <div class="col-6 pe-1">
                @include('elements.input', [
                    'label' => 'NIF',
                    'name' => 'nif',
                    'rules' => ['required'],
                    'default' => $data->nif ?? null
                ])
            </div>
            <div class="col-6 ps-1">
                @include('elements.input', [
                    'label' => 'STAT',
                    'name' => 'stat',
                    'rules' => ['required'],
                    'default' => $data->stat ?? null
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
                    'default' => $data->rcs ?? null
                ])
            </div>
            <div class="col-6 ps-1">
                @include('elements.input', [
                    'label' => 'Contact',
                    'name' => 'contact',
                    'rules' => ['required'],
                    'default' => $data->contact ?? null
                ])
            </div>
        </div>
    </div>
    <div class="form-group mb-3">            
        @include('elements.input', [
            'label' => 'Email',
            'name' => 'email',
            'rules' => ['required', 'email'],
            'default' => $data->email ?? null
        ])
    </div>
</div>