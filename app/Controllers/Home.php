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

    public function sport(): string
    {
        return view('sport');
    }

    public function dashboard(): string
    {
        return view('dashboard');
    }
    public function adminRegime(): string
    {
        return view('admin-regime');
    }
    public function adminSport(): string
    {
        return view('admin-sport');
    }   
}
