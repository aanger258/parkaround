<?php

namespace App;

use Illuminate\Support\Facades\DB;
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
        if(strpos($request->daysSelected, "SUNDAY"))
            $new_parking_spot->sunday = 1;
        if(strpos($request->daysSelected, "MONDAY"))
            $new_parking_spot->monday = 1;
        if(strpos($request->daysSelected, "TUESDAY"))
            $new_parking_spot->tuesday = 1;
        if(strpos($request->daysSelected, "WEDNESDAY"))
            $new_parking_spot->wednesday = 1;
        if(strpos($request->daysSelected, "THURSDAY"))
            $new_parking_spot->thursday = 1;
        if(strpos($request->daysSelected, "FRIDAY"))
            $new_parking_spot->friday = 1;
        if(strpos($request->daysSelected, "SATURDAY"))
            $new_parking_spot->saturday = 1;
	    $new_parking_spot->status = isset($request->status) ? $request->status : 0;
	    $new_parking_spot->type = isset($request->type) ? $request->type : 0;
        $new_parking_spot->details = $request->details;
        $new_parking_spot->price = isset($request->price) ? $request->price : 0;
        $array = [];
        if($new_parking_spot->save()){
        	$array = [];
            $array['key'] = $new_parking_spot->id;
            return json_encode($array);
        }
        $array['key'] = false;
        return json_encode($false);
    }

	public static function getParkingSpacesByAddress($data){
		$address = str_replace(" ","+",$data['address']);

		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyB6SQwqGyvpF4j0GTHTgcmMkLBvQCE_6pE';

	    $json = file_get_contents($url);

	    $data = json_decode($json, TRUE);
	    if($data['status']=="OK"){

            //analytics
            $sectors_array = array("Sector 1", "Sector 2", "Sector 3", "Sector 4", "Sector 5", "Sector 6");
            if(in_array($data['results'][0]['address_components'][1]['long_name'], $sectors_array)){
                DB::table('sectors')->where('sector', $data['results'][0]['address_components'][1]['long_name'])->increment('search_count');
            }
            if(in_array($data['results'][0]['address_components'][2]['long_name'], $sectors_array)){
                DB::table('sectors')->where('sector', $data['results'][0]['address_components'][2]['long_name'])->increment('search_count');
            }

	        $lat1 = $data['results'][0]['geometry']['viewport']['northeast']['lat'];
	        $lat2 = $data['results'][0]['geometry']['viewport']['southwest']['lat'];
	        $lng1 = $data['results'][0]['geometry']['viewport']['northeast']['lng'];
	        $lng2 = $data['results'][0]['geometry']['viewport']['southwest']['lng'];
	        $lat = ($lat1+$lat2)/2;
	        $lng = ($lng1+$lng2)/2;
	        $parkings_array = [];
	        $parkingSpots = Location::where('latitude', '<', $lat+0.007)->where('latitude', '>', $lat-0.007)->where('longitude', '<', $lng+0.007)->where('longitude', '>', $lng-0.007)->get();
	        foreach($parkingSpots as $parkingSpot){
	        	$parkings_array[$parkingSpot->id] = [
	        		'address' => $parkingSpot->address,
	        		'latitude' => $parkingSpot->latitude,
	        		'longitude' => $parkingSpot->longitude,
	        		'start_time' => $parkingSpot->start_time,
	        		'end_time' => $parkingSpot->end_time,
                    'sunday' => $parkingSpot->sunday,
                    'monday' => $parkingSpot->monday,
                    'tuesday' => $parkingSpot->tuesday,
                    'wednesday' => $parkingSpot->wednesday,
                    'thursday' => $parkingSpot->thursday,
                    'friday' => $parkingSpot->friday,
                    'saturday' => $parkingSpot->saturday,
	        		'status' => $parkingSpot->status,
	        		'type' => $parkingSpot->type,
	        		'details' => $parkingSpot->details,
	        		'price' => $parkingSpot->price,
	        	];
	        }
	        if(count($parkings_array) > 0)
        		return json_encode($parkings_array);
            $array['search_error'] = true;
        	return json_encode($array);
	    }
	    $array['google_api_error'] = true;
        return json_encode($array);
    }

	public static function getParkingSpacesByDirectLocation($data){
        $parkings_array = [];
        $parkingSpots = Location::where('latitude', '<', $data['latitude']+0.007)->where('latitude', '>', $data['latitude']-0.007)->where('longitude', '<', $data['longitude']+0.007)->where('longitude', '>', $data['longitude']-0.007)->get();
        foreach($parkingSpots as $parkingSpot){
        	$parkings_array[$parkingSpot->id] = [
        		'address' => $parkingSpot->address,
                'latitude' => $parkingSpot->latitude,
                'longitude' => $parkingSpot->longitude,
                'start_time' => $parkingSpot->start_time,
                'end_time' => $parkingSpot->end_time,
                'sunday' => $parkingSpot->sunday,
                'monday' => $parkingSpot->monday,
                'tuesday' => $parkingSpot->tuesday,
                'wednesday' => $parkingSpot->wednesday,
                'thursday' => $parkingSpot->thursday,
                'friday' => $parkingSpot->friday,
                'saturday' => $parkingSpot->saturday,
                'status' => $parkingSpot->status,
                'type' => $parkingSpot->type,
                'details' => $parkingSpot->details,
                'price' => $parkingSpot->price,
        	];
        }
        if(count($parkings_array) > 0)
        	return json_encode($parkings_array);
	    $array['search_error'] = true;
        return json_encode($array);
    }
}
