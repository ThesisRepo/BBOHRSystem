@component('mail::message')
# Hi This is just a sample !

@component('mail::button', ['url' => config('app.url')])
Click Here To Take An Action
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
