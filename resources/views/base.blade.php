<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>easylink | {{ user('usertype') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('assets/flag-icons-master/css/flag-icon.css')}}">
	<link rel="stylesheet" href="{{asset('assets/semantic/components/form.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/semantic/components/dropdown.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/semantic/components/transition.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
</head>
<body>
    <div class="wrapper with-sidebar-sm" id="wrapper">
        <div class="request-feedback">
            @include('elements.svg-alert')
            @if (session('success'))
                <div class="alert alert-success d-flex" role="alert">
                    <div class="d-flex align-items-start" style="flex: 1">
                        <div class="h-100 d-flex" style="padding-top: .1rem">
                            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#check-circle-fill"/></svg>
                        </div>
                        <div style="flex: 1">
                            <strong class="fs-14 alert-heading d-flex align-items-center">
                                <span>{{ __('Success') }}</span>
                            </strong>
                            <p class="m-0 fs-13">{{ session('successMessage') ?? __('Recording completed !') }}</p>
                        </div>
                    </div>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @error('delete-failed')
                <div class="alert alert-danger d-flex" role="alert">
                    <div class="d-flex align-items-start" style="flex: 1">
                        <div class="h-100 d-flex" style="padding-top: .1rem">
                            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        </div>
                        <div style="flex: 1">
                            <strong class="fs-14 alert-heading d-flex align-items-center">
                                <span>{{ __('Failed') }}</span>
                            </strong>
                            <p class="m-0 fs-13">{{ $message }}</p>
                        </div>
                    </div>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>              
            @enderror
        </div>
        <div class="sidebar" id="sidebar">
            <div class="brand">
                <h1 class="brand-name"><span>easy</span><span>link</span></h1>
                <span class="minimize" id="toggle-sidebar-desktop" role="button"></span>
            </div>
            <div class="sidebar-menu">
                @foreach (menusList(user('usertype')) as $menu)
                    
                <a href="{{ $menu->link }}" @class(['sidebar-menu-link', 'active' => $menu->active])>
                    <span class="icon">{!! $menu->icon !!}</span>
                    <span class="label">{{ $menu->label }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <div class="sidebar-mobile" id="sidebar-mobile">
            <div class="brand">
                <h1 class="brand-name"><span>easy</span><span>link</span></h1>
            </div>
            <div class="sidebar-menu">
                @foreach (menusList(user('usertype')) as $menu)
                    
                <a href="{{ $menu->link }}" @class(['sidebar-menu-link', 'active' => $menu->active])>
                    <span class="icon">{!! $menu->icon !!}</span>
                    <span class="label">{{ $menu->label }}</span>
                </a>
                @endforeach
            </div>
        </div>
        <div class="main">
            <div class="top-navbar bg-white">
                <div class="top-navbar-layout left">
                    <div class="lh-16">
                        <span>{{__('Welcome')}}</span> <strong>{{ user('lastname') ?? user('company_name') }}</strong>
                        <p class="m-0">
                            <small class="text-muted">{{ __('Dashboard ' . user('usertype')) }}</small>
                        </p>
                    </div>
                </div>
                <div class="top-navbar-layout middle">
                    <div class="lh-18">
                        <p class="m-0 w-100 text-center">
                            <small class="text-muted">{{ __('Your ID') }}</small>
                        </p>
                        <p class="m-0 w-100 text-center fs-20">
                            <strong>
                                @if (user('usertype') === 'client')
                                    {{ user('uid') }}
                                @else
                                    {{ user('username') }}
                                @endif
                            </strong>
                        </p>
                    </div>
                </div>
                <div class="top-navbar-layout right">
                    <span class="toggle-sidebar-mobile" role="button" id="toggle-sidebar-mobile">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </span>
                    <div class="desktop-only user-menu">
                        <div class="d-flex align-items-center">
                            @if (user('usertype') !== 'agent' && user('usertype') !== 'mada-agent')
                                <a href="{{ route(user('usertype') . ".message.index") }}" class="fs-20 link-secondary">
                                    <i class="fa-regular fa-envelope"></i>
                                </a>
                            @endif
                        </div>
                        <div class="dropdown ms-3">
                            <span role="button" class="dropdown-toggle fs-20" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-circle-user"></i>
                            </span>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route(user('usertype') . ".profil.index") }}">
                                        <span><i class="fa-regular fa-user"></i></span>
                                        <span class="ms-2">{{ __('Profile') }}</span>
                                    </a>
                                </li>
                                @if (user('usertype') === 'client')
                                    <li>
                                        <a class="dropdown-item" href="{{ route(user('usertype') . ".easylink") }}">
                                            <span><i class="fa-regular fa-hand-point-right"></i></span>
                                            <span class="ms-2">{{ __('My easylink') }}</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route(user('usertype') . ".logout") }}" method="post" class="dropdown-item">
                                        @csrf
                                        @method('delete')
                                        <button class="dropdown-btn">
                                            <span><i class="fa-solid fa-power-off"></i></span>
                                            <span class="ms-2">{{ __('Logout') }}</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown ms-3 d-flex align-items-center">
                            <span role="button" class="dropdown-toggle flag-icon {{ flagIcon(user('app_lang')) }}" data-bs-toggle="dropdown" aria-expanded="false"></span>
                            <ul class="dropdown-menu">
                                @foreach (languages(user('usertype')) as $lang) 
                                    <li>
                                        <form action="{{ route(user('usertype') . ".lang", ['code' => $lang->code]) }}" method="post" class="dropdown-item">
                                            @csrf
                                            @method('put')
                                            <button class="dropdown-btn">
                                                <span class="flag-icon {{ $lang->flag }}"></span>
                                                <span class="ms-2">{{ $lang->name }}</span>
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="content px-4">
                @yield('content')
            </div>
        </div>
    </div>


    <template id="modal-detail-loading-template">
        <div class="modal-loading-template">
            <div class="loader-container">
                <span class="loader"><svg viewBox="25 25 50 50"><circle r="20" cy="50" cx="50"></circle></svg></span>
            </div>
        </div>
    </template>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script type="module" src="//unpkg.com/@grafikart/drop-files-element"></script>
	<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="{{asset('assets/semantic/components/form.min.js')}}"></script>
	<script src="{{asset('assets/semantic/components/dropdown.js')}}"></script>
	<script src="{{asset('assets/semantic/components/transition.min.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/default.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{asset('assets/js/utils.js')}}"></script>
    <script src="{{asset('assets/js/ui.js')}}"></script>
    <script src="{{asset('assets/js/checkbox.js')}}"></script>
    <script>
        $('.ui.dropdown').semanticdropdown()
    </script>
    @include('script-utils')
    @yield('javascript')
</body>
</html>