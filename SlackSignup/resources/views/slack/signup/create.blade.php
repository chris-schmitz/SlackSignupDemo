@extends('base.layout')

@section('title')
Signup
@stop

@section('content')
    <p>
        STL Full Stack Web Development is a meetup group in Saint Louis, Missouri that meets monthly to review topics that make up the web development world.
    </p>
    <p>
        <form v-form name="signupForm" action="{{ route('slack.signup.store') }}" method="POST">
            Submitting your email on this form will:
            <ul>
                <li class="checkbox">
                    <label>
                        <input type="checkbox" name="invites[]" value="meetup" v-model="invites.meetup" class="checkbox">Add you to the Meetup group.
                    </label>
                </li>
                <li class="checkbox">
                    <label>
                        <input type="checkbox" name="invites[]" value="slack" v-model="invites.slack" class="checkbox">Add you to the Slack chat
                    </label>
                </li>
            </ul>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="email">First Name</label>
                        <div>
                            <input type="text" name="nameFirst" v-model="name.first" class="form-control" placeholder='optional'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Last Name</label>
                        <div>
                            <input type="text" name="nameLast" v-model="name.last" class="form-control" placeholder='optional'>
                        </div>
                    </div>
                    <div class="form-group" :class="{'has-error': emailHasError}">
                        <label for="email">Email</label>
                        <div>
                            <input type="email" name="email" v-model="email.value" v-form-ctrl :required="email.isRequired" class="form-control" placeholder='required'>
                            <span v-show="emailHasError" class="help-block">You need to provide an email to sign up.</span>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div type="submit" @click="submit" class="btn btn-success">Submit</div>
                </div>
            </div>
        </form>
    </p>

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
