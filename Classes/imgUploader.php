<?php
session_start();

require_once("resizeimage.php");


class imgUploader {

function uploadImgwithThumbnail($filename,$big_path,$thumb_path,$w,$h,$loop) 
{

//var_dump($_FILES);
//exit;

$updFile = $filename;
$filename = $_FILES[$updFile]['name'][$loop];
$uploadedfile = $_FILES[$updFile]['tmp_name'][$loop];


if (eregi('^image/pjpeg(;.*)?$', $_FILES[$updFile]['type'][$loop]) 
	or eregi('^image/gif(;.*)?$', $_FILES[$updFile]['type'][$loop])
	or eregi('^image/jpeg(;.*)?$', $_FILES[$updFile]['type'][$loop])) { 


 
 	$picturefile = $_FILES[$updFile]['tmp_name'][$loop];
 	$picturename = $_FILES[$updFile]['name'][$loop];
 	$picturetype = $_FILES[$updFile]['type'][$loop];


	$big_path = $big_path.time().'_'. basename( $_FILES[$updFile]['name'][$loop]); 
	$thumb_path = $thumb_path.time().'_'. basename( $_FILES[$updFile]['name'][$loop]); 

     //Copying Files of Original Size
     $handle = fopen($picturefile,'rb');
	 fread($handle,filesize($picturefile));
	 copy($picturefile,$big_path);
	 fclose($handle);	
	
	//Creating Thumbnails and Moving Files
	$myimg1 = resizeImage($picturefile,$w,$h,$picturetype);
   if($picturetype == 'image/jpg' || $picturetype == 'image/jpeg' ){
    imagejpeg($myimg1,$picturefile,100);
	}
  if($picturetype == 'image/gif'){	
    imagegif($myimg1,$picturefile,100);
	}
	
	  if(move_uploaded_file($picturefile, $thumb_path)) {
		   $msg =  "Success";
			} else{
       	   $msg   =  "Failure";
			}
	}

   return urlencode($big_path).",".urlencode($thumb_path).",".$picturename.",".$msg;
 }




function uploadImgwithnoThumbnail($filename,$target_path,$loop) 
{

$updFile = $filename;
$filename = $_FILES[$updFile]['name'][$loop];
$uploadedfile = $_FILES[$updFile]['tmp_name'][$loop];


if (eregi('^image/pjpeg(;.*)?$', $_FILES[$updFile]['type'][$loop]) 
	or eregi('^image/gif(;.*)?$', $_FILES[$updFile]['type'][$loop])
	or eregi('^image/jpeg(;.*)?$', $_FILES[$updFile]['type'][$loop])) { 


 
 	$picturefile = $_FILES[$updFile]['tmp_name'][$loop];
 	$picturename = $_FILES[$updFile]['name'][$loop];
 	$picturetype = $_FILES[$updFile]['type'][$loop];

	$target_path = $target_path.time().'_'. basename( $_FILES[$updFile]['name'][$loop]); 


	  if(move_uploaded_file($picturefile, $target_path)) {
		   $msg =  "Success";
			} else{
       	   $msg   =  "Failure";
			}
     }
   
   return urlencode($target_path).",".$picturename.",".$msg;
 }

} //end class
?>