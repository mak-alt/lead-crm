<x-mail::message>
# Complete Your Registration

Dear {{ $user->name }},

Welcome to {{ config('app.name') }}. Please complete your profile by clicking on following button

<x-mail::panel>
Email: {{ $user->email }}
</x-mail::panel>

@php

$url = url('/complete/profile').'?email='.Crypt::encryptString($user->email);

@endphp

<x-mail::button :url="$url">
Complete Profile
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
