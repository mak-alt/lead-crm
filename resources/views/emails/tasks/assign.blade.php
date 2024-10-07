<x-mail::message>
# Task Assigned

Dear {{ $member->name }},<br>
A New Task Assigned to You <b>#{{ $task->task_no }}</b><br>
Website: {{ $task->website->name }}<br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
