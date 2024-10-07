<x-mail::message>
# New Team Added

New Team <b>#{{ $team->team_no }} Was Added</b><br>
Website: {{ $team->website->name }}<br>
Added By: {{ $team->user->name }}({{ $team->user->email }})

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
