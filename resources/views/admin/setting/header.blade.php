<h2 class="fs-18 py-2 text-primary">{{__("Platform setup")}}</h2>

<ul class="nav nav-underline nav-swipe mb-4">
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'admin.setting.index']) href="{{ route('admin.setting.index') }}">{{ __("Categories") }}</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'admin.unit.index']) href="{{ route('admin.unit.index') }}">{{ __("Unit exchange") }}</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'admin.setting.cbm']) href="{{ route('admin.setting.cbm') }}">{{ __("CBM Min.") }}</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => currentRouteName() === 'admin.localization.index']) href="{{ route('admin.localization.index') }}">{{ __("Localization") }}</a>
    </li>
</ul>