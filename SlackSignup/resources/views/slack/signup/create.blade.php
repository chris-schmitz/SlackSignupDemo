@extends('base.layout')

@section('title')
Signup
@stop

@section('content')

    <signupcomponent></signupcomponent>
    <p>
    For more information about the group:
        <ul>
            <li>
                <a href="http://www.meetup.com/SaintLouis_FullStack_WebDevelopment/">The Meetup group can be found here.</a>
            </li>
            <li>
                <a href="https://trello.com/b/6hIv1Oux/stl-full-stack-web-meetup-group">The trello board with a list of proposed and upcoming topics can be found here.</a>
                <small class='annotation'>To join the trello board and proposed topics.</small>
            </li>
        </ul>
    </p>
@stop
