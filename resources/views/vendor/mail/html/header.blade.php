@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ $url }}/build/assets/img/logo-menu.png" class="logo" alt="Logo">
@else
<img src="{{ $url }}/build/assets/img/logo-menu.png" class="logo" alt="Logo">
@endif
</a>
</td>
</tr>
