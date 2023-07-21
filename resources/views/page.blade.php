@extends('layouts/default')

@section('content')
@if ($entry->body)
{!! View::parse($entry->body, compact('entry'))->render() !!}
@else
<div class="flex flex-wrap min-h-screen">
    <main class="w-full mx-auto">
        @foreach ($entry->content ?: [] as $block)
        {{dd($block)}}
        @endforeach
    </main>
</div>
@endif
@endsection
