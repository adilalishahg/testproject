<?php
#-----------------------------------------------#
#				PHP Mail Function				#
#		Designed & Developed by Abid Malik		#
#			 Dated :	16 January 2010			#
#-----------------------------------------------#


function  mail_it($to, $from, $subject, $message, $name, $contact, $header)
{
	
	# Defines Contact Information
	$cnt_add = 'Hybrid Track Trans';
	$cnt_add = '928 S Terrace Rd, #104 Tempe, AZ , 85281 ';
	$cnt_num= 'Phone TEL:(480) 717-5032';
	
	if(!$header)
	{
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
	$headers .= 'To: '.$name.' <'.$to.'>' . "\r\n";
	
	if($from == 'support@hybridtracktrans.com')
	{
	$headers .= 'From: HTT Support<'.$from.'> ' . "\r\n"; 
	}
	else if($from == 'requests@hybridtracktrans.com')
	{
	$headers .= 'From: HTT Requests<'.$from.'> ' . "\r\n"; 
	}
	else if($from == 'admin@hybridtracktrans.com')
	{
	$headers .= 'From: HTT Admin<'.$from.'> ' . "\r\n"; 
	}
	else
	{
	$headers .= 'From: HTT<'.$from.'> ' . "\r\n"; 
	}
		
	}
	else
	{
		$headers  = $header;
	}
	//$headers .= 'From: SPCNA <'.$from.'>' . "\r\n";
	//$headers .= 'Cc: sajid@hybridTracktrans.com'. "\r\n";
	
	
	$mail_content = '<body style=" margin: 0; padding:0; font-family: Verdana, Geneva, sans-serif; font-size:10px;">
	<div id="container" style="width: 100%;">
       <div id="inner_container" style=" width: 838px; margin:auto;">
       		<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td>
                    	<img src="http://174.121.23.216/images/email_header.jpg" alt="" />
                    </td>
                </tr>
		<tr>
                	<td>
                    	<div  style="float:left; width: 800px; padding: 15px; font-size:12px">
                        	<p>';
		//------------------------ Message Body ----------------------------/
		$mail_content .= "Dear ";
		if($name!='')
		{
			$mail_content .= $name;
		}
		  $mail_content .= "<br /><br />";
		  $mail_content .= $message;
		  $mail_content .= "<br /><br />";
		  $mail_content .= 'Regards, <br /><br />

If you need any help or any other assistance, please contact <i>HTT Global Transport</i> Administrator at <a href="mailto:admin@hybridtracktrans.com">admin@hybridTracktrans.com</a> or call (602) 324-7178.

                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td>
                    	<div id="footer" style="float: left; background:#787372; width:100%; height: 90px;">
                        	<div class="name" style="float: left; padding-left: 10px; padding-top: 5px;">';
		if($contact)
		{
			$mail_content  .= '<strong><span style="font-size:11;">'.$cnt_title.'</span></strong><br />
        	<span style="font-size:9;">'.$cnt_add.'<br />'.
         	 $cnt_num ;
		}
		$mail_content .= '<br />
                                <a href="http://www.hybriditservices.com/demos/httglobal-2/">http://www.hybriditservices.com/demos/httglobal-2/</a><br />
                                This email is not spam / junk and generated on your request, if you receive this email in junk / spam, Please unmark junk / spam</p></span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
       </div>
    </div></body>';
	if(mail($to, $subject, $mail_content, $headers))
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>
