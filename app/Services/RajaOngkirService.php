<?php

namespace App\Services;

use GuzzleHttp\Client;

class RajaOngkirService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('rajaongkir.base_url');
        $this->apiKey = config('rajaongkir.api_key');
    }

    public function getProvinces()
    {
        $response = $this->client->request('GET', $this->baseUrl . 'province', [
            'headers' => [
                'key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCities($provinceId)
    {
        $response = $this->client->request('GET', $this->baseUrl . 'city', [
            'headers' => [
                'key' => $this->apiKey,
            ],
            'query' => [
                'province' => $provinceId,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getSubdistricts($cityId)
    {
        $response = $this->client->request('GET', $this->baseUrl . 'subdistrict', [
            'headers' => [
                'key' => $this->apiKey,
            ],
            'query' => [
                'city' => $cityId,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
