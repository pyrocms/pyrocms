@extends('layouts/default')

@section('content')
<div class="flex flex-wrap min-h-screen">
    <main class="w-full mx-auto">
        {!! View::parse($entry->body, compact('entry'))->render() !!}
    </main>
</div>
@endsection
