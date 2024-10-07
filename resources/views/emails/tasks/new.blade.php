<x-mail::message>
# New Task Added

New Task <b>#{{ $task->task_no }} Was Added</b><br>
Status: {{ $task->taskStage->name }}<br>
Website: {{ $task->website->name }}<br>
Added By: {{ $task->user->name }}({{ $task->user->email }})

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
