<?php
/*------------------------------------------------------------------------------------------
     Micro Image Manipulation Pack

     ©PhpToys 2006
     http://www.hybriditservices.com/demos/httglobal-2/phptoys.com

     Released under the terms and conditions of the
     GNU General Public License (http://gnu.org).

     $Revision: 1.0 $
     $Date: 2006/07/03 $
     $Author: PhpToys $
     
     USAGE:
          This package has 3 function to manipulta jpeg images with php code.
          - resizeImage : needs a filename and a width, height values.
          - dropShadow  : needs an image as image resource and not as filename, and you can define 
                          the shadow size.
          - createBorder: needs an image as image resource and not as filename, and the border 
                          width and height values.
--------------------------------------------------------------------------------------------*/
function resizeImage($originalImage,$toWidth,$toHeight,$type){
    
    // Get the original geometry and calculate scales
    list($width, $height) = getimagesize($originalImage);
    $xscale=$width/$toWidth;
    $yscale=$height/$toHeight;
    
    // Recalculate new size with default ratio
    if ($yscale>$xscale){
        $new_width = round($width * (1/$yscale));
        $new_height = round($height * (1/$yscale));
    }
    else {
        $new_width = round($width * (1/$xscale));
        $new_height = round($height * (1/$xscale));
    }

    // Resize the original image
    $imageResized = imagecreatetruecolor($new_width, $new_height);
   if($type == 'image/jpeg' || $type == 'image/jpg'){
    $imageTmp     = imagecreatefromjpeg ($originalImage);
    }
   if($type == 'image/gif'){
    $imageTmp     = imagecreatefromgif ($originalImage);
    }	
    imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    return $imageResized;
}

function createBorder($img,$x,$y){
    
    // Create image base 
    $image           = imagecreatetruecolor($x,$y);
    $backgroundColor = imagecolorallocate($image,255,255,255);
    $borderColor     = imagecolorallocate($image,50,50,50);
    
    imagefill($image,0,0,$backgroundColor);
    imagerectangle($image,0,0,$x-1,$y-1, $borderColor);

    $width  = imagesx($img);
    $height = imagesy($img);
    
    imagecopymerge($image,$img,($x-$width)/2,($y-$height)/2,0,0,$width,$height,100);

    return $image;
}


function dropShadow($img,$shadowSize=5){

  // Set the new image size  
  $width  = imagesx($img)+$shadowSize;
  $height = imagesy($img)+$shadowSize;
  
  $image = imagecreatetruecolor(imagesx($img)+$shadowSize, imagesy($img)+$shadowSize);

  for ($i = 0; $i < 10; $i++){
    $colors[$i] = imagecolorallocate($image,255-($i*25),255-($i*25),255-($i*25));
  }

  // Create a new image
  imagefilledrectangle($image, 0,0, $width, $height, $colors[0]);

  // Add the shadow effect
  for ($i = 0; $i < count($colors); $i++) {
    imagefilledrectangle($image, $shadowSize, $shadowSize, $width--, $height--, $colors[$i]);
  }

  // Merge with the original image
  imagecopymerge($image, $img, 0,0, 0,0, imagesx($img), imagesy($img), 100);

  return $image;
  
}

?>