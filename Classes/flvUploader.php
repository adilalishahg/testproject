<?php
session_start();

require_once("flvsize.php");


class flvUploader {

function uploadVideo($filename,$target_path,$i) 
{
//var_dump($_FILES);
//exit;
//$updFile = "'".$filename."'";
$updFile = $filename;
$filename = $_FILES[$updFile]['name'][$i];
$uploadedfile = $_FILES[$updFile]['tmp_name'][$i];

	
  if(empty($_FILES[$updFile]['name'][$i])){
  	$target_path =  '0'; 
 } else{	
	$target_path = $target_path.time().'_'. basename($_FILES[$updFile]['name'][$i]); 

}	
	$videofile = $_FILES[$updFile]['tmp_name'][$i];
 	$videoname = $_FILES[$updFile]['name'][$i];
 	$videotype = $_FILES[$updFile]['type'][$i];
 
	  if(move_uploaded_file($videofile, $target_path)) {
		   $msg =  "File Uploaded Successfully";
			} else{
       	   $msg   =  "File Uploading Failed";
			}


          $duration = GetFLVDuration($target_path);

		  $secs = floor($duration/1000);
		 
		 if($secs >= 60)
		 {
			$mints = floor($secs/60);
			$secs = $secs-60;
			$duration = $mints."mins:".$secs."secs";
		 }else{
			$duration = $secs."secs";
			} 

   return $target_path.",".$filename.",".$duration.",".$msg;


  }


} //end class
?>