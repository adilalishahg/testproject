<?php
	include_once('../Classes/mapquest_google_miles.class.php');
	$mile_C = new mapquest_google_miles;
	if($_REQUEST){
	$add1 	= ($_REQUEST['add1']);	
	$add2	= ($_REQUEST['add2']);
	require_once('DBAccess/Database.inc.php');
	$db = new Database;	
	$db->connect();
	$Sl="SELECT miles FROM address WHERE TRIM(LOWER(REPLACE(pickaddress,' ','')))='".strtolower(trim(str_replace(' ','',$add1)))."' 
									AND  TRIM(LOWER(REPLACE(dropaddress,' ','')))='".strtolower(trim(str_replace(' ','',$add2)))."' AND miles > 0 ";
									if($db->query($Sl) && $db->get_num_rows() > 0){ 
	 								$data = $db->fetch_one_assoc(); $miles = round(($data['miles']),2);}else{
										$dt = round($mile_C->distance($add1,$add2),2); //echo 'select query'; exit;
										$up="INSERT INTO address SET pickaddress='".$add1."',dropaddress='".$add2."',miles='".$dt."',dated='".date('Y-m-d')."'"; 
											$db->execute($up);
										$miles = round(($dt),2);
										}
	
	echo 	$miles;
	}
?>

