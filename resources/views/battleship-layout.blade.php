<div class="flex justify-center px-10 py-10 w-full">
    <div>
        @foreach($map['board'] as $board)
            @if($loop->index === 0)
                <div id="attack-map" class="flex flex-col">
                    <span class="text-center text-3xl uppercase">Attack Field</span>
                    <div class="grid grid-cols-11 content-center">
                        @foreach($board as $key => $value)
                            <a id="A{{ $loop->iteration }}"
                                hx-get="{{ route('game.battleship.attack') }}"
                                class="w-10 h-10 border border-black text-center {{ implode(' ', $value['options']) }}">{{ $value['value'] }}</a>
                        @endforeach
                    </div>
                </div>
            @else
                <div id="defence-map" class="flex flex-col pt-10">
                    <span class="text-center text-3xl uppercase">Defend</span>
                    <div class="grid grid-cols-11 content-center">
                        @foreach($board as $key => $value)
                            <div id="D{{ $loop->iteration }}"
                                class="w-10 h-10 border border-black text-center {{ implode(' ', $value['options']) }}">{{ $value['value'] }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

    </div>
</div>