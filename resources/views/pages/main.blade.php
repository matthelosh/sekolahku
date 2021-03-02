@extends('index')

@section('content')
    @switch($page)
        @case('dashboard')
                @include('pages.dashboard')
            @break
        @case(2)
            
            @break
        @default
            
    @endswitch
@endsection