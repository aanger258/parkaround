<?php

namespace App\Http\Controllers;

use Validator;
use App\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public static function addParkingSpotByDirectLocation(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        if($validator->fails()) {
            return json_encode($validator->errors());
        }
        return Location::addNewParkingSpotByDirectLocation($request);
    }

    public static function getParkingSpacesByAddress(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'address' => 'required',
        ]);
        if($validator->fails()) {
            return json_encode($validator->errors());
        }
        return Location::getParkingSpacesByAddress($request);
    }

    public static function getParkingSpacesByDirectLocation(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        if($validator->fails()) {
            return json_encode($validator->errors());
        }
        return Location::getParkingSpacesByDirectLocation($request);
    }
}
