@component('mail::message')

<b>Drogi Administratorze!</b><br><br>

Informujemy o nowej wiadomości na stronie mypassion.pl od użytkownika o emailu {!! $message->email !!}<br><br>

<h2>Treść:</h2>
{!! $message->contents !!}

@endcomponent
