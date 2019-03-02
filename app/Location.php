<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [
        'id'
    ];

    public static function addNewParkingSpotByDirectLocation(Request $request){
        $new_parking_spot = new Location;
        $new_parking_spot->user_id = $request->id;
        $new_parking_spot->address = isset($request->address) ? $request->address : " ";
        $new_parking_spot->longitude = $request->longitude;
        $new_parking_spot->latitude = $request->latitude;
        $new_parking_spot->start_time = $request->start_time;
        $new_parking_spot->end_time = $request->end_time;
	    $new_parking_spot->status = isset($request->status) ? $request->status : 0;
	    $new_parking_spot->type = isset($request->type) ? $request->type : 0;
        $new_parking_spot->details = $request->details;
        $new_parking_spot->price = isset($request->price) ? $request->price : 0;
        if($new_parking_spot->save())
            return $new_parking_spot->id;
        return "false";
    }

	public static function getParkingSpacesByAddress($data){
		$address = str_replace(" ","+",$data['address']);

		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyB6SQwqGyvpF4j0GTHTgcmMkLBvQCE_6pE';

	    $json = file_get_contents($url);

	    $data = json_decode($json, TRUE);

	    if($data['status']=="OK"){
	        //var_dump($data['results']);
	        // foreach ($data['results'] as $key => $data) {
	        // 	echo $key;
	        // }
	        $lat1 = $data['results'][0]['geometry']['viewport']['northeast']['lat'];
	        $lat2 = $data['results'][0]['geometry']['viewport']['southwest']['lat'];
	        $lng1 = $data['results'][0]['geometry']['viewport']['northeast']['lng'];
	        $lng2 = $data['results'][0]['geometry']['viewport']['southwest']['lng'];
	        $lat = ($lat1+$lat2)/2;
	        $lng = ($lng1+$lng2)/2;

	    }
    }
}
