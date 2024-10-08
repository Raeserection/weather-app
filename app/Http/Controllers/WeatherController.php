<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    private function convertTemperature($temperature)
    {
        return round(($temperature - 273.15), 0);
    }

    public function index()
    {
        $API_KEY = env('OPENWEATHERMAP_API_KEY');
        $city = "Tokyo";
        $url = 'https://api.openweathermap.org/data/2.5/forecast?q=' . $city . '&appid=' . $API_KEY;

        $response = Http::get($url);
        if ($response->successful()) {
            $data = $response->json();

            $temp = $this->convertTemperature($data['list'][0]['main']['temp']);
            $humidity = $data['list'][0]['main']['humidity'];
            $wind = round($data['list'][0]['wind']['speed'], 2);
            $clouds = round($data['list'][0]['clouds']['all'], 2);
            $pressure = round($data['list'][0]['main']['pressure'], 2);
            $weather = $data['list'][0]['weather'][0]['main'];
            $weatherDescription = $data['list'][0]['weather'][0]['description'];
            $country = $data['city']['country'];
            $icon = $data['list'][0]['weather'][0]['icon'];
            $iconUrl = 'http://openweathermap.org/img/w/' . $icon . '.png';

            $days = [6, 13, 21, 29]; // Indices for the next 4 days

            for ($i = 0; $i < 4; $i++) {
                ${"day{$i}Temp"} = $this->convertTemperature($data['list'][$days[$i]]['main']['temp']);
                ${"icon{$i}"} = $data['list'][$days[$i]]['weather'][0]['icon'];
                ${"icon{$i}Url"} = 'http://openweathermap.org/img/w/' . ${"icon{$i}"} . '.png';
            }

            return view('results', compact('city', 'country', 'temp', 'humidity', 'wind', 'clouds', 'pressure', 'weather', 'weatherDescription', 'iconUrl', 'day0Temp', 'day1Temp', 'day2Temp', 'day3Temp', 'icon0Url', 'icon1Url', 'icon2Url', 'icon3Url'));
        } else {
            return redirect()->route('home')->with('error', 'Failed to fetch weather data.');
        }
    }

    public function showResults(Request $request)
    {
        $API_KEY = env('OPENWEATHERMAP_API_KEY');
        $GEO_API_KEY = env('GEOAPIFY_API_KEY');

        if ($request->input('city') == '') {
            return redirect()->route('home')->with('error', 'Please enter a city name.');
        }

        $cityToken = $request->input('placeID');
        // dd($cityToken);
        $city = $request->input('city');
        $url = 'https://api.openweathermap.org/data/2.5/forecast?q=' . $city . '&appid=' . $API_KEY;

        $geoUrl = 'https://api.geoapify.com/v2/place-details?id=' . $cityToken . '&features=details,details.names&apiKey=' . $GEO_API_KEY;

        $response = Http::get($url);

        $responseGeo = Http::get($geoUrl);

        if ($response->successful()) {
            $data = $response->json();
            $dataGeo = $responseGeo->json();

            

            $timezone = $dataGeo['features'][0]['properties']['timezone']['offset_STD'] ?? null;
            $website = $dataGeo['features'][0]['properties']['website'] ?? null;
            // Log::info('responseGeo: ', [$responseGeo->json()]);
            // $timezone = 'What';
            // $website = 'What';

            $temp = $this->convertTemperature($data['list'][0]['main']['temp']);
            $humidity = $data['list'][0]['main']['humidity'];
            $wind = round($data['list'][0]['wind']['speed'], 2);
            $clouds = round($data['list'][0]['clouds']['all'], 2);
            $pressure = round($data['list'][0]['main']['pressure'], 2);
            $weather = $data['list'][0]['weather'][0]['main'];
            $weatherDescription = $data['list'][0]['weather'][0]['description'];
            $country = $data['city']['country'];
            $icon = $data['list'][0]['weather'][0]['icon'];
            $iconUrl = 'http://openweathermap.org/img/w/' . $icon . '.png';

            $days = [6, 13, 21, 29]; // Indices for the next 4 days
            for ($i = 0; $i < 4; $i++) {
                ${"day{$i}Temp"} = $this->convertTemperature($data['list'][$days[$i]]['main']['temp']);
                ${"icon{$i}"} = $data['list'][$days[$i]]['weather'][0]['icon'];
                ${"icon{$i}Url"} = 'http://openweathermap.org/img/w/' . ${"icon{$i}"} . '.png';
            }

            return view('results', compact('timezone','website','city', 'country', 'temp', 'humidity', 'wind', 'clouds', 'pressure', 'weather', 'weatherDescription', 'iconUrl', 'day0Temp', 'day1Temp', 'day2Temp', 'day3Temp', 'icon0Url', 'icon1Url', 'icon2Url', 'icon3Url'));
        } else {
            return redirect()->route('home')->with('error', 'Failed to fetch weather data.');
        }
    }
}
