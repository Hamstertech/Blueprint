<div class="flex justify-center px-10 py-10 w-full">
    <div hx-ext="ws" ws-connect="/test">
        <div id="attack-map" class="flex flex-col">
            <span class="text-center text-3xl uppercase">Attack Field</span>
            <div class="grid grid-cols-11 content-center">
                @foreach($map['board'][0] as $key => $value)
                    <a
                        hx-post="{{ route('game.battleship.attack') }}"
                        id="A{{ $loop->index }}"
                        class="w-10 h-10 border border-black text-center {{ implode(' ', $value['options']) }}">{{ $value['value'] }}</a>
                @endforeach
            </div>
        </div>

        <div id="defence-map" class="flex flex-col pt-10">
            <span class="text-center text-3xl uppercase">Defend</span>
            <div class="grid grid-cols-11 content-center">
                @foreach($map['board'][1] as $key => $value)
                    <div
                        id="D{{ $loop->index }}"
                        class="w-10 h-10 border border-black text-center {{ implode(' ', $value['options']) }}">{{ $value['value'] }}</div>
                @endforeach
            </div>
        </div>
    </div>
</div>