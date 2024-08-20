<div class="flex flex-col">
    <span class="text-center text-3xl">Attack</span>
    <div class="grid grid-cols-11 content-center">
        @for($i = 0; $i < 11; $i++)
            @if($i === 0)
                <div class="w-10 h-10 border border-black text-center"></div>
            @else
                <div class="w-10 h-10 border border-black text-center">{{ $i }}</div>
            @endif
            @foreach ($alphabet as $letter)
                @if($i === 0)
                    <div class="w-10 h-10 border border-black text-center">{{ $letter }}</div>
                @else
                    <div id="A{{ $i . $letter }}" class="w-10 h-10 border border-black text-center"></div>
                @endif
            @endforeach
        @endfor
    </div>
</div>