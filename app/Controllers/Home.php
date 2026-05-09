<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index-front');
    }

    public function regime(): string
    {
        return view('regime');
    }
}
