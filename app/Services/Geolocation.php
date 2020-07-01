<?php

namespace App\Services;

use GuzzleHttp\Client;

class Geolocation
{
    public function getCoordinates(string $address)
    {
        $client = new Client();

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s";
        $url = sprintf($url, urlencode($address), env('GOOGLE_API_TOKEN', ''));

        $result = json_decode($client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ])->getBody()->getContents())->results;

        return $result[0];
    }
}
