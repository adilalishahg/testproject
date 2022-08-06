<?php

class ziparchiver{

//ExTrackt Zip File
function xTrackt($src,$dst)
 {
 $zip = new ZipArchive();
	if ($zip->open($src) === TRUE) {
		$zip->exTracktTo($dst);
		$zip->close();
		
		$msg = 'Files ExTrackted Successfully';
		return $msg;
	} else {
		$msg = 'Unable to ExTrackt the files';
		return $msg;
	} 
 }


//Delete a file
function delFile($arch,$file)
 {
	$zip = new ZipArchive;
	if ($zip->open($arch) === TRUE) {
		$zip->deleteName($file);
		$zip->close();
		return 'File Removed Successfully from <b>'.$arch.'</b>';
	} else {
		return 'Unable to create <b>'.$arch.'</b>';
	}
}


//Create an archive
/*
function creatArchive($arch,$file){
	$zip = new ZipArchive;

	$zip->open($arch, ZIPARCHIVE::OVERWRITE);
	$zip->addFile($file);
	$zip->close();
	return '<b>'.$arch.'</b> Created Successfully';
}
*/


}
?> 
