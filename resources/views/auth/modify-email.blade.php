<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/auth.css">
    <title>Client | Change email</title>
</head>
<body>
    <div class="wrapper">
        <div class="layout left d-flex justify-content-center align-items-center">
            <h1 class="text-light">Publicité easylink</h1>
        </div>
        <div class="layout right">
            <div class="header">
                <h2 class="fs-22">Modification email</h2>
                <p class="text-center fs-14 m-0">Saisissez votre nouveau adresse email</p>
            </div>
            <form method="POST" class="auth-form js-form" action="{{ route('client.update-email') }}">
                @method('PUT')
                @csrf
                <div class="form-group mb-3">            
                    @include('elements.input', [
                        'label' => 'Votre nouveau email',
                        'name' => 'email',
                        'rules' => ['required', 'email'],
                        'class' => ['form-control-lg'],
                        'default' => $client->email
                    ])
                </div>

                <div class="form-group mb-5">
                    <button class="btn btn-success btn-lg w-100">
                        <span class="fs-18 fw-300">Modifier</span>
                    </button>
                </div>

                
            </form>
        </div>
    </div>

    <script src="assets/js/ui.js"></script>
    @include('script-utils')
</body>
</html>