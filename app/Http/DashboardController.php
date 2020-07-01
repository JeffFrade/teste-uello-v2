<?php

namespace App\Http;

use App\Core\Support\Controller;
use App\Services\Geolocation;

class DashboardController extends Controller
{
    private $geolocation;

    public function __construct(Geolocation $geolocation)
    {
        $this->geolocation = $geolocation;
    }

    public function index()
    {
        dd($this->geolocation->getCoordinates('Avenida Dr. Gastão Vidigal'));
        return view('dashboard');
    }
}
