<?php

namespace App\Http\Controllers;

use Geocoder\Laravel\ProviderAndDumperAggregator as Geocoder;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyB6SQwqGyvpF4j0GTHTgcmMkLBvQCE_6pE';

        $json = file_get_contents($url);

        $data = json_decode($json, TRUE);

        if($data['status']=="OK"){
            dd($data['results']);
        }
    }

    public static function getParkingSpots(Request $request)
    {
    	$url = 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyB6SQwqGyvpF4j0GTHTgcmMkLBvQCE_6pE';

        $json = file_get_contents($url);

        $data = json_decode($json, TRUE);
        if($data['status']=="OK"){
            dd($data['results']);
        }
    }
}
