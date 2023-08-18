<x-mail::message>
# Confirmation inscription

Votre code de confirmation: <strong style="font-size: 18px">{{ $client->email_confirmation_code }}</strong>

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

<small>Merci pour votre confiance à nos service,</small><br>
<strong>easylink</strong>
</x-mail::message>
