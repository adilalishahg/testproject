<?php 
function GetFLVDuration($file){
  
  // get contents of a file into a string
  if (file_exists($file)){
    $handle = fopen($file, "r");
    $contents = fread($handle, filesize($file));
    fclose($handle);
    //
    if (strlen($contents) > 3){
      if (substr($contents,0,3) == "FLV"){
        $taglen = hexdec(bin2hex(substr($contents,strlen($contents)-3)));
        if (strlen($contents) > $taglen){
          $duration = hexdec(bin2hex(substr($contents,strlen($contents)-$taglen,3)))  ;
		  return $duration;
        }
      }
    }
  }
  return false;
}
?>
