@extends('layouts.welcome')

@section('content')
    @if (session('status'))
        <h3 style="color: green">
            {{ session('status') }}
        </h3>
    @endif
    <div class="title m-b-md">
        @if(env('APP_LOGO'))
            <div><img src="{{env('APP_LOGO')}}" /></div>
        @endif
        {{ config('app.name') }}
    </div>
@endsection
