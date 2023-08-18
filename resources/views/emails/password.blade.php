<x-mail::message>
# Reinitialisation de mot de passe

Votre nouveau mot de passe: <strong style="font-size: 24px">{{ $password }}</strong>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
