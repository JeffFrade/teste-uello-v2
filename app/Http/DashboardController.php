<?php

namespace App\Http;

use App\Core\Support\Controller;
use App\Repositories\ClienteRepository;
use App\Services\Csv;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $csv;
    private $clienteRepository;

    public function __construct(Csv $csv, ClienteRepository $clienteRepository)
    {
        $this->csv = $csv;
        $this->clienteRepository = $clienteRepository;
    }

    public function index()
    {
        $clientes = $this->clienteRepository->paginate();

        return view('dashboard', compact('clientes'));
    }

    public function import(Request $request)
    {
        $request = $this->validate($request, [
            'csv' => 'required|file'
        ]);

        $this->csv->import($request['csv']);

        return redirect(route('dashboard'));
    }

    public function export()
    {
        $filename = $this->csv->export();

        return response()->download($filename);
    }
}
