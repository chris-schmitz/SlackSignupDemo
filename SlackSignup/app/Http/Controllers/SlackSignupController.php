<?php

namespace App\Http\Controllers;

use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlackSignupController extends Controller
{

    public function create()
    {
        return view('slack.signup.create');
    }

    public function store(Request $request, Signup $signups)
    {
        $data = $request->all();

        $signupData = [
            'first_name' => $data['name']['first'],
            'last_name' => $data['name']['last'],
            'email' => $data['email'],
        ];

        $signups->persist($signupData);

        return $this->response('test', 200, ['name' => 'chris'], [['type' => 'CONTENT-TYPE', 'value' => 'lol', 'force' => true]]);
    }
}
