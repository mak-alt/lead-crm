@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('public/assets/images/logo-dark.png') }}" class="logo" alt="Digitalogies Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
