<div id="defence-map" class="flex flex-col">
    {{-- <span class="text-center text-3xl">Attack</span> --}}
    <div class="grid grid-cols-11 content-center">
        @foreach($attack_map as $key => $value)
            <a
                hx-get="{{ route('battleship.attack') }}"
                hx-trigger="click"
                hx-target="#defence-map"
                hx-swap="outerHTML"
                id="{{ $loop->index }}"
                class="w-10 h-10 border border-black text-center {{ $value['options'] }}">{{ $value['value'] }}</a>
        @endforeach
    </div>
</div>