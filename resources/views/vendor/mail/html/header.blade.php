@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<!-- <imgsrc="https://merch-sentry.com/static/media/backgroundConnexion.e24921124015d69d0c33.png" class="logo" alt="merch-sentry Logo"> -->
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
