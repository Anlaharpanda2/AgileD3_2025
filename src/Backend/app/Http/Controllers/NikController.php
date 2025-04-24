<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NikController extends Controller
{
    public function cekNik(Request $request)
    {
        $nik = $request->input('no');
        
        $client = new Client();
        try {
            $response = $client->post('https://nik-checker1.p.rapidapi.com/ktp', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'x-rapidapi-host' => 'nik-checker1.p.rapidapi.com',
                    'x-rapidapi-key' => env('RAPIDAPI_KEY'), // API Key disimpan di .env
                ],
                'form_params' => [
                    'no' => $nik,
                ]
            ]);

            $body = $response->getBody();
            $data = json_decode($body);

            if ($data->isValid) {
                return response()->json(['isValid' => true]);
            } else {
                return response()->json(['isValid' => false], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error connecting to API'], 500);
        }
    }
}
