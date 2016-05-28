@extends('base.email')

@section('content')
    <div class="well">
        <p>
            Hey {{ $payload['name'] }},
        </p>
        <p>
            {{ $payload['message'] }}
        </p>
        <p>
            <a href="{{ $payload['link'] }}">{{ $payload['link'] }}</a>
        </p>
    </div>
@stop
