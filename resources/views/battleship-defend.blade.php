<div id="defence-map" class="flex flex-col">
    <span class="text-center text-3xl">Defend</span>
    <div class="grid grid-cols-11 content-center">
        @foreach($defence_map as $key => $value)
            <a
                {{-- hx-get="{{ route('battleship.defend') }}"
                hx-trigger="click"
                hx-target="#defence-map"
                hx-swap="outerHTML" --}}
                id="{{ $loop->index }}"
                class="w-10 h-10 border border-black text-center">{{ $value }}</a>
        @endforeach
    </div>
</div>