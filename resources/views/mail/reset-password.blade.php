<x-mail::panel>
    <x-slot name="header">
        <x-mail::header :url="route('login')">
            <a href="{{route('login')}}" style="display: inline-block;">
                <img src="{{config('app.logo')}}" alt="{{config('app.name')}}">
            </a>
        </x-mail::header>
    </x-slot>

    <x-mail::message>
        {!! $content !!}
    </x-mail::message>
</x-mail::panel>