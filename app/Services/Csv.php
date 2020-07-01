<?php

namespace App\Services;

use App\Helpers\DateHelper;
use App\Helpers\StringHelper;
use App\Repositories\ClienteRepository;
use App\Repositories\EnderecoRepository;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Csv
{
    private $clienteRepository;
    private $enderecoRepository;
    private $geolocation;

    public function __construct()
    {
        $this->clienteRepository = new ClienteRepository();
        $this->enderecoRepository = new EnderecoRepository();
        $this->geolocation = new Geolocation();
    }

    public function import(UploadedFile $file)
    {
        $reader = IOFactory::createReader("Csv");
        $csv = $reader->load($file->getRealPath())->getActiveSheet()->toArray();
        unset($csv[0]);

        foreach ($csv as $row) {
            $data = $this->geolocation->getCoordinates($row[4]);

            $this->storeCliente($row);

            $cpf = StringHelper::removeSpecialChars($row[3]);
            $this->storeEndereco($data, $cpf);
        }
    }

    public function export()
    {
        $clientes = $this->clienteRepository->all();

        $filename = Carbon::now()->format('dmYHis') . '_registros.csv';
        $filename = storage_path() . '/app/public/' . $filename;

        $header = ["nome", "email", "datanasc", "cpf", "endereco", "cep"];

        $fp = fopen($filename, "w");

        fputcsv($fp, $header, ';');

        foreach ($clientes as $cliente) {
            $data = [
                $cliente->nome,
                $cliente->email,
                DateHelper::formatDate($cliente->data_nascimento),
                StringHelper::mask($cliente->cpf, '###.###.###-##'),
                $cliente->endereco->logradouro . ", " . $cliente->endereco->numero . " " . $cliente->endereco->complemento . " - " . $cliente->endereco->bairro . " - " . $cliente->endereco->cidade,
                StringHelper::mask($cliente->endereco->cep, '#####-###')
            ];

            fputcsv($fp, $data, ';');
        }

        fclose($fp);

        return $filename;
    }

    private function storeCliente(array $row)
    {
        $clienteData = [
            'nome' => $row[0],
            'email' => $row[1],
            'data_nascimento' => DateHelper::parseDateTime($row[2]),
            'cpf' => StringHelper::removeSpecialChars($row[3]),
        ];

        $this->clienteRepository->create($clienteData);
    }

    private function storeEndereco($data, $cpf)
    {
        $enderecoTypes = [
            'subpremise' => 'complemento',
            'street_number' => 'numero',
            'route' => 'logradouro',
            'political' => 'bairro',
            'administrative_area_level_2' => 'cidade',
            'postal_code' => 'cep',
        ];

        $enderecoData = [
            'latitude' => $data->geometry->location->lat,
            'longitude' => $data->geometry->location->lng,
            'cpf' => $cpf,
        ];

        $endereco = $data->address_components;

        foreach ($endereco as $item => $value) {
            if (in_array($value->types[0], array_flip($enderecoTypes))) {
                $enderecoData[$enderecoTypes[$value->types[0]]] = StringHelper::removeCep($value->long_name);
            }
        }

        $this->enderecoRepository->create($enderecoData);
    }
}
