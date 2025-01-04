
@if(session()->has('success'))
    <div x-data x-init="$notification({text:'{{session("success")}}',variant:'success',position:'right-bottom'})"></div>
    @php
        session()->forget('success')
    @endphp
@endif

@if(session()->has('error'))
    <div x-data x-init="$notification({text:'{{session("error")}}',variant:'error',position:'right-bottom'})"></div>
    @php
        session()->forget('error')
    @endphp
@endif