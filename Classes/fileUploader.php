<?php
class fileUploader {

function uploadfile($filename,$target_path,$i) 
{
//var_dump($_FILES);
//exit;
//$updFile = "'".$filename."'";

$updFile = $filename;
$filename = $_FILES['uploadpdf']['name'][$i];
$uploadedfile = $_FILES[$updFile]['tmp_name'][$i];


    $target_path = $target_path .time().'_'. basename($_FILES[$updFile]['name'][$i]); 

	$file      = $_FILES[$updFile]['tmp_name'][$i];
 	$filename2 = $_FILES[$updFile]['name'][$i];
 	$pathinfo  = pathinfo($filename2);
	$filetype  = $pathinfo['extension'];
    $filesize  = $_FILES[$updFile]['size'][$i];	  
	
	 if($filetype == 'pdf' || $filetype == 'doc' || $filetype == 'docx')
	   {
	      if(move_uploaded_file($file, $target_path)) {
		      $msg =  "File Uploaded Successfully,yes";
			   } else{
       	      $msg   =  "File Uploading Failed,no";
			   }
             return $target_path.",".$filename2.",".$filesize.",".$msg;
       }
  else{
	          return $target_path.",".$filename2.",".$filesize.",".'file format not supported,no';
      }  
 }
} //end class

?>