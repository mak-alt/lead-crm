<x-mail::message>
# Successful Registration

Dear {{ $user->name }},

Welcome to {{ config('app.name') }}. Please login with your given credentials!

<x-mail::panel>
Email: {{ $user->email }}
</x-mail::panel>

@php

$url = route('auth.login');

@endphp

<x-mail::button :url="$url">
Get Started
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
