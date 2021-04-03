@props(['color'])
@php $randomId = Str::random(6); @endphp
<div id="alert-{{$randomId}}" {{ $attributes->merge(['class' => "bg-$color-100 border-l-4 border-$color-500 text-$color-700 p-4 relative"]) }} role="alert">
    <p class="font-bold">{{$title}}</p>
    <p>{{ $slot }}</p>
    <button
        class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none"
        onclick="document.getElementById('alert-{{$randomId}}').remove();">
        <span>×</span>
    </button>

</div>
