@extends('base.email')

@section('content')
    Hey {{ $payload['name'] }},

    <p>
        You've been added to the {{ $payload['teamName'] }} Slack team.
    </p>

    <p>
        Please use following link to set your password per the email you provided in the signup form: <a href="{{ $payload['teamLink'] }}">{{ $payload['teamLink'] }}</a>
    </p>

    <p>
        Thanks!<br>
        {{ $payload['teamName'] }}
    </p>
@stop
