<?php
include_once('distance.class.php');
class mapquest_google_miles {
public function distance($add1,$add2){
	$key="AIzaSyBBE53xDKH93kCWSWREyehlzH8N_t2R2lw"; // Google Key: this key can be use only for testing purpose please replace it on live mode.&key=AIzaSyBBE53xDKH93kCWSWREyehlzH8N_t2R2lw
	try{    $url = 'https://voice.hybriditservices.com/googleapi.php';
			$clienttoken_post = array('strSource'=> 'JWR','SourceType'=> 'Distance Matrix','apikeyused'=> 'AIzaSyBBE53xDKH93kCWSWREyehlzH8N_t2R2lw');
		   $curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, true);
		   curl_setopt($curl, CURLOPT_POSTFIELDS, $clienttoken_post);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$json_response = curl_exec($curl);
		curl_close($curl);
	//    $responce = json_decode($json_response, true);
		// return true;
	 }
	catch (Exception $e) { }
			
	$letters1 = array(' ','#');
	$replace1 = array('+','No');	
	$add1 = str_replace($letters1,$replace1,$add1);
	$add2 = str_replace($letters1,$replace1,$add2);
	 $miles_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$add1.'&destinations='.$add2.'&units=imperial&key='.$key);
$data=json_decode($miles_data,true);
if($data['status'] == 'OK'){ 
$miles = (round($data['rows'][0]['elements'][0]['distance']['value'])/1609.34);
return(round($miles,2));}
	}
public function distance2($add1,$add2,$dp,$db){
	$dp='';
	try{    $url = 'https://voice.hybriditservices.com/googleapi.php';
			$clienttoken_post = array('strSource'=> 'JWR','SourceType'=> 'Distance Matrix','apikeyused'=> 'AIzaSyBBE53xDKH93kCWSWREyehlzH8N_t2R2lw');
		   $curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, true);
		   curl_setopt($curl, CURLOPT_POSTFIELDS, $clienttoken_post);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$json_response = curl_exec($curl);
		curl_close($curl);
	//    $responce = json_decode($json_response, true);
		// return true;
	 }
	catch (Exception $e) { }
	$letters1 = array(' ','#');
	$replace1 = array('+','No');	
	$add1 = str_replace($letters1,$replace1,$add1);
	$add2 = str_replace($letters1,$replace1,$add2);
	 $miles_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$add1.'&destinations='.$add2.'&units=imperial'.$dp.'&key='.$key);
$data=json_decode($miles_data,true);
//print_r($data);exit;
if($data['status'] == 'OK'){ 
			$distance_in_meter 	= $data['rows'][0]['elements'][0]['distance']['value'];
			$time_in_second 	= $data['rows'][0]['elements'][0]['duration']['value']; 
			return  array("distance"=>$distance_in_meter,"time"=>$time_in_second);
			  				}else{/*
			$Qd="DELETE FROM googlekeys WHERE key= '".$key."' LIMIT 1"; if($db->query($Qd)){ $Qinstr="INSERT INTO googlekeys SET key = '".$key."'"; $db->query($Qinstr); 
				  $Query = "SELECT * FROM ".googlekeys." WHERE 1=1  ORDER BY `id` ASC LIMIT 1";
   if($db->query($Query) && $db->get_num_rows() > 0)
	{	   $keydata = $db->fetch_one_assoc(); }
	$key=$keydata['key'];
	$letters1 = array(' ','#');
	$replace1 = array('+','No');	
	$add1 = str_replace($letters1,$replace1,$add1);
	$add2 = str_replace($letters1,$replace1,$add2);
	 $miles_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$add1.'&destinations='.$add2.'&units=imperial'.$dp.'&key='.$key);
$data=json_decode($miles_data,true);
if($data['status'] == 'OK'){ 
			$distance_in_meter 	= $data['rows'][0]['elements'][0]['distance']['value'];
			$time_in_second 	= $data['rows'][0]['elements'][0]['duration']['value']; 
			    return  array("distance"=>$distance_in_meter,"time"=>$time_in_second); }
				  }
			  */}
/*$miles = (round($data['rows'][0]['elements'][0]['distance']['value'])/1609.34);//[0]['value']
return(round($miles,2));*/
	}	
public function distance___mapquest($add1,$add2){
	$key="Fmjtd%7Cluub29ur25%2Crl%3Do5-96z254"; //this key can be use only for testing purpose please replace it on live mode.
	$letters1 = array(' ','#');
	$replace1 = array('+','No');	
	$add1 = str_replace($letters1,$replace1,$add1);
	$add2 = str_replace($letters1,$replace1,$add2);
	$miles_data = @file_get_contents('http://www.mapquestapi.com/directions/v1/route?key='.$key.'&callback=renderAdvancedNarrative&ambiguities=ignore&avoidTimedConditions=false&doReverseGeocode=true&outFormat=json&routeType=fastest&timeType=1&enhancedNarrative=false&shapeFormat=raw&generalize=0&locale=en_US&unit=m&from='.$add1.'&to='.$add2.'&drivingStyle=2&highwayEfficiency=21.0');
$miles_hisa = explode('distance', $miles_data);	
$hunrAA = $miles_hisa[1];
$miles_hisa_short = explode('"time"', $hunrAA);	
$hunrJA = str_replace('":','',$miles_hisa_short[0]);
$phirAJA = str_replace(',','',$hunrJA);
$phirAJAa = str_replace(' ','',$phirAJA);
	return $phirAJAa;
	}	
public function distanceGoogle($add1,$add2){
	$letters1 	= array(' ','#');
	$replace1 	= array('+','No');	
	$add1 		= str_replace($letters1,$replace1,$add1);
	$add2 		= str_replace($letters1,$replace1,$add2);
	$geocode1	= file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$add1.'&sensor=false'); 
	$output1	= json_decode($geocode1);  	
	$lat1 		= $output1->results[0]->geometry->location->lat;  	
	$long1 		= $output1->results[0]->geometry->location->lng; 
	$geocode2	= file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$add2.'&sensor=false'); 
	$output2	= json_decode($geocode2);  	
	$lat2 		= $output2->results[0]->geometry->location->lat;  	
	$long2 		= $output2->results[0]->geometry->location->lng;
		$dist = 'http://maps.google.com/maps/nav?q=from:'.$lat1.','.$long1.'%20to:'.$lat2.','.$long2.'';
		$data = @file_get_contents($dist);
		$result = explode(',', $data);
		for($i=0; $i<count($result); $i++){ if (preg_match('/Distance/', $result[$i] )){ $required = $result[$i]; break; } }
		$required; 
		$kholo =explode(':',$required);
		$mile_hisa = $kholo[2];
		$miles = round(($mile_hisa * 0.000621371192), 2); return $miles;
	}	
public function distance_cord($cor1,$cor2,$miles = true)
{ $latlong=explode(',',$cor1);
	$lat1=$latlong[0];
	$lng1=$latlong[1];
	$latlong2=explode(',',$cor2);
	$lat2=$latlong2[0];
	$lng2=$latlong2[1];
	$pi80 = M_PI / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;
	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;
	return ($miles ? ($km * 0.621371192) : $km);
}	
public	function reverstime($time){
		$time_exp = explode(':',$time);
		$hour = $time_exp[0];
		$minutess = $time_exp[1]; 
		if($hour < 12)	{ $returnpickup = $time; $mad = 'am'; }
		if($hour == 12)	{ $returnpickup = $time; $mad = 'pm'; }
		if($hour > 12 && ($hour-12)<10)	{ $returnpickup = '0'.($hour-12).':'.($minutess); $mad = 'pm'; }
		if($hour > 12 && ($hour-12)>9)	{ $returnpickup = ($hour-12).':'.($minutess); $mad = 'pm'; }
			 return $returnpickup.','.$mad;
		}	//return in amp pm fromate i.e 12 hour formate.
public function hoursconvert($time,$ampm){
		$time1 		= explode(':',$time);
		$hour 		= $time1[0];
		$minutess 	= $time1[1];
	if($ampm == pm){ if($hour != 12) { $time = ($hour+12).':'.($minutess); } }
	return $time; } 	//	return in amp pm fromate i.e 24 hour formate.	
	
public  function getLatLong_old($address){
    //if (!is_string($address))die("All Addresses must be passed as a string");
    $_url = 'http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false';															   //sprintf('http://maps.google.com/maps?output=js&q=%s',rawurlencode($address));
    $_result = false;
    if($_result = file_get_contents($_url)) {// print_r($_result); exit;
        if(strpos($_result,'errortips') > 1 || strpos($_result,'Did you mean:') !== false) return false;
        preg_match('!center:\s*{lat:\s*(-?\d+\.\d+),lng:\s*(-?\d+\.\d+)}!U', $_result, $_match);
        $lat  = $_match[1];
        $long = $_match[2];
		$_coords = $lat.','.$long; 
    }
    return $_coords;
}
public  function getLatLong($address){
	//Using Map Quest
	$key="Fmjtd%7Cluub29ur25%2Crl%3Do5-96z254";
   $json = file_get_contents('http://open.mapquestapi.com/geocoding/v1/address?key='.$key.'&location='.str_replace(' ','%20',$address)); 
	$jsonArr = json_decode($json, true);
	$_coords = $jsonArr['results'][0]['locations'][0]['latLng']['lat'].','.$jsonArr['results'][0]['locations'][0]['latLng']['lng']; 
    return $_coords;	
}	
}



