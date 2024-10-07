<x-mail::message>
# New Lead Added

New Lead <b>#{{ $lead->lead_no }} Was Added</b>
Website: {{ $lead->website->name }}<br>
Added By: {{ $lead->user->name }}({{ $lead->user->email }})

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
