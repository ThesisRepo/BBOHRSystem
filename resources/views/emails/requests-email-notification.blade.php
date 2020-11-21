@component('mail::message')
# Hi {{ $username }} !

{{ $message }} .

@component('mail::button', ['url' => 'http://localhost:8000/'])
Click Here To Take An Action
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
