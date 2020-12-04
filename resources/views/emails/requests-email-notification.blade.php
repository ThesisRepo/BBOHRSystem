@component('mail::message')
# Hi {{ $username }} !

{{ $message }} .

@component('mail::button', ['url' => config('app.url')])
Click Here To Take An Action
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
