@extends('base.email')

@section('content')
    <div class="well">
        <p>
            The invitee {{ $inviteeName }} has requested invites for the following:
            <ul>
                @foreach($inviteArray as $invite)
                    <li>{{ $invite }} </li>
                @endforeach
            </ul>
        </p>
    </div>
@stop
