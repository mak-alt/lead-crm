<x-mail::message>
# Team Assigned

Dear {{ $member->name }},<br>
Welcome to Team <b>#{{ $team->team_no }}</b><br>
Website: {{ $team->website->name }}<br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
