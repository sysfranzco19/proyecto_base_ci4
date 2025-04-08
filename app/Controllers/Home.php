<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data['vista'] = 'home';
		return view('home', $data);
    }
}
