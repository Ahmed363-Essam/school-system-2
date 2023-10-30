@component('mail::message')
# Introduction


the name is {{ $grade }}



@component('mail::button', ['url' => 'https://www.youtube.com/watch?v=nc3iPL7_3PY&list=PLftLUHfDSiZ4GfPZxaFDsA7ejUzD7SpWa&index=63'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
