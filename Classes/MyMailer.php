<?php
class MyMailer
{
function SimpleTxtMail($to,$from,$subject,$message)
{
  $sent = mail($to,$subject,$message,$from);
    if($sent)
     {  return true; }else{ return false; }
}
function HtmlTxtMail($to,$from,$subject,$message)
{
     	$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        if($from == 'requests@hybridtracktrans.com'){
		$headers .= 'From: Hybrid Track Trans Support<'.$from.'> ' . "\r\n"; 
        }
        else if($from == 'requests@hybridtracktrans.com'){
		$headers .= 'From: Hybrid Track Trans Requests<'.$from.'> ' . "\r\n"; 
        }
        else if($from == 'requests@hybridtracktrans.com'){
		$headers .= 'From: Hybrid Track Trans Admin<'.$from.'> ' . "\r\n"; 
        }
        else{
		$headers .= 'From: Hybrid Track Trans <'.$from.'> ' . "\r\n"; 
        }
    	  $sent = mail($to,$subject,$message,$headers);
    if($sent)
     {  return true; }else{ return false; }
}
//HTML Text Mail with CC, BCC
function HtmlTxtMailCC($to,$cc,$from,$subject,$message)
{
     	$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From : <'.$from.'> ' . "\r\n";      
		if($cc != ''){
		$headers .= 'CC : <'.$cc.'> ' . "\r\n"; }
    	  $sent = mail($to,$subject,$message,$headers);
    if($sent)
     {  return true; }else{ return false; }
}
}
?>