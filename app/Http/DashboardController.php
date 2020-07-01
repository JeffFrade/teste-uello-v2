<?php

namespace App\Http;

use App\Core\Support\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('home');
    }
}
