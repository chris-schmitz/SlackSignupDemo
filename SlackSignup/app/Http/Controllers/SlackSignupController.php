<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SlackSignupController extends Controller
{

    public function create()
    {
        return view('slack.signup.create');
    }

    public function store(Request $request)
    {
        return 'stored';
    }
}
