@component('mail::message')
# Introduction

The body of your message.
data
{{$user['token']]}}
@component('mail::button', ['url' => 'http://localhost:8000/user/activation/'.$user['token']])
Login and Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
