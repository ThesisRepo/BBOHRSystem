@component('mail::message')
# Introduction

The body of your message.
data
{{$user['token']}}
@component('mail::button', ['url' => config('app.url') . '/user/activation/'.$user['token']])
Login and Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
