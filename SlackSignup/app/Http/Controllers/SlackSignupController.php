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
        // validation
        $data = $request->all();

        $signupData = [
            'first_name' => $data['name']['first'],
            'last_name' => $data['name']['last'],
            'email' => $data['email'],
        ];

        $signups->persist($signupData);

        return $this->response('Signup successful.', 500);
    }
}
