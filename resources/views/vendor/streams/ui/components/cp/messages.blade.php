<!-- messages.blade.php -->
<div class="c-messages    fixed bottom-2 right-2">

    @foreach (Messages::pull() as $message)
    
    @switch($message['type'])
        @case('success')
            @php $color = 'green'; @endphp
            @break
        @case('error')
            @php $color = 'red'; @endphp
            @break
        @case('info')
            @php $color = 'blue'; @endphp
            @break
        @default
            
    @endswitch

    <div class="flex items-center bg-{{ $color }} text-black shadow-sm w-72 text-sm font-bold px-4 py-4 rounded mt-2" role="alert">
        <div class="flex-grow">
            <p>{{ $message['content'] }}</p>
        </div>
        <button class="opacity-75 hover:opacity-100 self-end" onclick="this.parentNode.remove();">
            {{-- <x-heroicon-s-x class="h-6 w-6" /> --}}
        </button>
    </div>

    @endforeach

</div>
