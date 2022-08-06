<?php


session_start();


include_once("DBaccess.php");


require_once("fileUploader.php");





Class DataLogic extends DBaccess


{





#### function to get add page ####


function addPage()


{


	$this->connectToDB();


	


	 $pgName   = $_POST['pgName'];


	 $pgTitle  = $_POST['pgTitle'];


	 $pgStatus = $_POST['pgStatus'];


	 $pgdel    = $_POST['dynpage'];


	 


	 if(!isset($pgStatus)) { $status = 'inactive'; }


	 if($pgStatus == 'on') { $status = 'active'; }	


	


	$getData = $this->GetRecord('tbl_contents','pgname',$pgName);


	$qury = mysql_num_rows($getData);


	


	 if($qury == '0')


	  {


	 $insert = 'pgname,contTitle,content,contStatus,deleteable';


	 $values = "'".$pgName."','".$pgTitle."','','".$status."','".$pgdel."'"; 	


	 $result= $this->InsertRecord('tbl_contents',$insert,$values);





if($result)


	    {


  	$path = explode('administrator',$_SERVER['SCRIPT_FILENAME']);


            $root = $path[0];


			$Writecontent = "<?php include_once('header.php');?>


							<tr>


							<td align=\"left\" valign=\"top\">


							<?php include_once('body.php');?>


							</td>


							<td align=\"left\" valign=\"top\" background=\"images/right.jpg\">&nbsp;</td>


							</tr>


							<?php include_once('footer.php');?>";


			$fp = @fopen($root.$pgName,'w'); 


			if(!$fp)


			{ die('Error cannot create '.$pgName.' file'); }


            else {


            fwrite($fp,$Writecontent); //Write to file


			fclose($fp);


             }


         }


	 $this->DBDisconnect();


	 return $result;


	}


 else {


		  echo '<script>alert("Error: Page with this name already exist");</script>';


		  echo '<script>window.open("addPage.php","_parent");</script>';			  


		  }	


}








#### function to edit page ####


function editPage($id)


{





	$this->connectToDB();


	


	 $pgName  = $_POST['pgName'];


	 $pgTitle = $_POST['pgTitle'];


	 $hidpgName = $_POST['hidfname'];


	 $hidcontent = $_POST['hidcontent'];	 	 


	 $pgStatus = $_POST['pgStatus'];


	


	 if(!isset($pgStatus)) { $status = 'inactive'; }


	 if($pgStatus == 'on') { $status = 'active'; }	


	


	 $insert = 'pgname,contTitle,contStatus';


	 $values = $pgName."^".$pgTitle."^".$status; 	


	 $result=$this->MultipleUpdateRecord('tbl_contents', $insert, $values, 'contId' ,$_GET['eId']);


	   if($result)


	    {


		    //Removing the Original file


		$rename = rename('../../'.$hidpgName,'../../'.$pgName);


	//	 if($rename) { echo 'renaming successful'; exit; } else { echo 'renaming failed'; exit; }	


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function getPageInfo($id)


{


	$this->connectToDB();


	


	 $result=$this->GetRecord('tbl_contents', 'contId', $id);


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("listpages.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}














#### function to get page information ####


function getnewsletterInfo($id)


{


	$this->connectToDB();


	


	 $result=$this->GetRecord('tbl_newsletter', 'nid', $id);


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("newsletterslist.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


#### function to get page information ####


function getContent($pgname)


{


	$this->connectToDB();


	


	if($pgname != 'newsletter.php')


	{


	 $result=$this->GetRecord('tbl_contents', 'pgname', $pgname);


	 }


	if($pgname == 'newsletter.php'){


	 $result=$this->GetRecord('tbl_newsletter','ntype',$_GET['type']);	


	}


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}





#### function to get page information ####


function Contentpages()


{


	$this->connectToDB();


	


	 $result=$this->fetchAllRecord('tbl_contents');


	   if(!$result)


	    {


          echo '<script>alert("Error executing the query");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}





#### function to get page information ####


function getCateogories()


{


	$this->connectToDB();


	


	$Query = "SELECT * FROM tbl_categories WHERE pid=0";


	 $result=$this->CustomQuery($Query);


	   if(!$result)


	    {


          echo '<script>alert("Error executing the query");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function getsubCateogories($id)


{


	$this->connectToDB();


	


	$Query = "SELECT * FROM tbl_categories WHERE pid=".$id;


	 $result=$this->CustomQuery($Query);


	   if(!$result)


	    {


          echo '<script>alert("Error executing the query");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}











#### function to get page information ####


function getproductsBylimit($pid,$catid,$offset,$limit)


{


	$this->connectToDB();


	


	$Query = "SELECT * FROM tbl_categories AS t1 JOIN tbl_products AS t2 JOIN tbl_pics AS t3 


	ON(t1.id=t2.cat_id AND t2.pid=t3.pid) WHERE t2.pid= ".$pid." OR t1.id=".$catid." LIMIT ".$offset." , ".$limit;


	


	 $result=$this->CustomQuery($Query);


	   if(!$result)


	    {


          echo '<script>alert("Error executing the query");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function getproductsByCatandlimit($catid,$offset,$limit)


{


	$this->connectToDB();


	


 $qry = "SELECT * FROM `tbl_survey_answer` WHERE UserId='".$_SESSION['uid']."'";





 $xecute = $this->CustomQuery($qry);


 $QrynumRows = mysql_num_rows($xecute); 


 


    if($QrynumRows == 0){	


	


	$Query = "SELECT * FROM tbl_categories AS t1 JOIN tbl_products AS t2 JOIN tbl_pics AS t3 


	ON(t1.id=t2.cat_id AND t2.pid=t3.pid) WHERE t1.id='".$catid."' AND t2.openauc ='1' GROUP BY t2.pid LIMIT ".$offset." , ".$limit;


	


	} else


	{


		if(isset($_SESSION['username']))


	    {	


	$Query = "SELECT * FROM tbl_categories AS t1 JOIN tbl_products AS t2 JOIN tbl_pics AS t3 


	ON(t1.id=t2.cat_id AND t2.pid=t3.pid) WHERE t1.id='".$catid."' GROUP BY t2.pid LIMIT ".$offset." , ".$limit;


	    }


	  


	   if(!isset($_SESSION['username']))


	   {


	$Query = "SELECT * FROM tbl_categories AS t1 JOIN tbl_products AS t2 JOIN tbl_pics AS t3 


	ON(t1.id=t2.cat_id AND t2.pid=t3.pid) WHERE t1.id='".$catid."' AND t2.openauc ='1' GROUP BY t2.pid LIMIT ".$offset." , ".$limit;


    	}


     }	  


	 


	 


	 


	 $result=$this->CustomQuery($Query);


	   if(!$result)


	    {


          echo '<script>alert("Error executing the query");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}





#### function to get page information ####


function getproducts($pid,$catid)


{


	$this->connectToDB();


	


	$Query = "SELECT * FROM tbl_categories AS t1 JOIN tbl_products AS t2 JOIN tbl_pics AS t3 


	ON(t1.id=t2.cat_id AND t2.pid=t3.pid) WHERE t2.pid= ".$pid." OR t1.id=".$catid;


	


	 $result=$this->CustomQuery($Query);


	   if(!$result)


	    {


          echo '<script>alert("Error executing the query");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function getproductsByCat($catid)


{


	$this->connectToDB();





 $qry = "SELECT * FROM `tbl_survey_answer` WHERE UserId='".$_SESSION['uid']."'";





 $xecute = $this->CustomQuery($qry);


 $QrynumRows = mysql_num_rows($xecute); 


 


    if($QrynumRows == 0){	





	$Query = "SELECT * FROM tbl_categories AS t1 JOIN tbl_products AS t2 JOIN tbl_pics AS t3 


	ON(t1.id=t2.cat_id AND t2.pid=t3.pid) WHERE t1.id='".$catid."' AND t2.openauc='1' GROUP BY t2.pid";	


	


	} else 


	 {		


	


	if(isset($_SESSION['username']))


	 {


	$Query = "SELECT * FROM tbl_categories AS t1 JOIN tbl_products AS t2 JOIN tbl_pics AS t3 


	ON(t1.id=t2.cat_id AND t2.pid=t3.pid) WHERE t1.id='".$catid."' GROUP BY t2.pid";


     }


	 


	if(!isset($_SESSION['username']))


	 {	 


	$Query = "SELECT * FROM tbl_categories AS t1 JOIN tbl_products AS t2 JOIN tbl_pics AS t3 


	ON(t1.id=t2.cat_id AND t2.pid=t3.pid) WHERE t1.id='".$catid."' AND t2.openauc='1' GROUP BY t2.pid";


     }


    }	


	 $result=$this->CustomQuery($Query);


	   if(!$result)


	    {


          echo '<script>alert("Error eoducts AS t2 JOIN tbl_pics AS t3 


	ON(t1.id=t2.cat_id AND t2.pid=t3.pid) WHERE t2.pid=".$pid")</script>';


	


	 $result=$this->CustomQuery($Query);


	   if(!$result)


	    {


          echo '<script>alert("Error executing the query");</script>';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}





#### function to get page information ####


function getPageList($offset,$limit)


{


	$this->connectToDB();


	


	 $result=$this->fetchRecord('tbl_contents', $offset, $limit);


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function getsubscribersList($offset,$limit)


{


	$this->connectToDB();


	


	 $result=$this->CustomQuery("SELECT username,fname,surname,email,status,newsletter FROM tbl_members LIMIT ".$offset.",".$limit);


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}





#### function to get page information ####


function getnewsletterList($offset,$limit)


{


	$this->connectToDB();


	


	 $result=$this->fetchRecord('tbl_newsletter', $offset, $limit);


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function ShowCart()


{


	$this->connectToDB();


	 


	 $cartId = $this->GetCartId();


	 $count = 1;


	 $totAmount = 0;


	 


	 $query = "SELECT * FROM tbl_cart AS t1 INNER JOIN tbl_products AS t2 ON(t1.itemId = t2.pid) WHERE t1.cookieId = '".$cartId."' ORDER BY t2.title ASC";





	 $result = $this->CustomQuery($query);


     $numRowz = mysql_num_rows($result);


	 	 


	   if($numRowz == 0)


	    {


          echo 'There is no item in the cart';


	      $this->DBDisconnect();


		 }


  else {		


	$sql="SELECT * FROM `tbl_shipping_prices` WHERE `shipid`=1";


	$result_shipping=mysql_query($sql);


	$row_shipping=mysql_fetch_assoc($result_shipping);


	


   


?>


<form name="cart" id="cart"  action="" method="" onsubmit="" >	


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bordered">


  <tr>


    <td width="6%" class="fieldcellheading "  style="padding-bottom:10px;"><strong>S.No</strong></td>


    <td width="36%" class="fieldcellheading " style="padding-bottom:10px;"><strong>Item</strong></td>


    <td width="26%" class="fieldcellheading " style="padding-bottom:10px;"><strong>Quantity</strong></td>


    <td width="13%" class="fieldcellheading " style="padding-bottom:10px;"><strong>Amount</strong></td>


    <td width="19%" class="fieldcellheading " style="padding-bottom:10px;"><strong>Action</strong></td>


  </tr>


<?php


      while($cart = mysql_fetch_object($result))


      {


     $amount = ($cart->qty*$cart->price);


     $totAmount = $totAmount + $amount;


 ?>





  <tr>


    <td class="fieldcell"><?php echo $count++; ?></td>


    <td class="fieldcell"><?php echo $cart->title; ?></td>


    <td class="fieldcell">


	<select name="quantity" id="quantity" onChange="UpdateQty(this.value,<?php echo $cart->pid; ?>);">


	<?php


	for($i = 1; $i <= 20; $i++)


	{ 


	  if($cart->qty == $i) { $select = 'Selected'; } else { $select = ''; }


	?>


	<option value="<?php echo $i; ?>" <?php echo $select; ?>><?php echo $i; ?></option>


	<?php } ?>


	</select>	</td>


    <td class="fieldcell"><?php echo $amount; ?></td>


    <td class="fieldcell"><a href="javascript:removeItem(<?php echo $cart->pid; ?>)">remove</a></td>


  </tr>


<?php } ?>


  <tr>


    <td class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td align="right" class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td colspan="2" align="right" class="fieldcell" style="padding-top:10px;"><strong>


	Sub Total


	</strong>&nbsp;&nbsp;$<?php echo $totAmount; ?>	</td>


  </tr>


  <tr>


    <td class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td align="right" class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td colspan="2" align="right" class="fieldcell" style="padding-top:10px;"><strong>Shipping & Handling


	</strong>&nbsp;&nbsp;$


	<?php echo number_format($row_shipping['price'], 2, ".", ","); ?>


	<?php $_SESSION['shipping_amount']=$row_shipping['price'];  


	echo $_SESSION['shipping_amount'];


	?>


	</td>


    </tr>


  <tr>


    <td class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td align="center" class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td colspan="2" align="right" class="fieldcell" style="padding-top:10px;"><strong>Total Amount


	</strong>&nbsp;&nbsp;


	$<?php echo number_format($totAmount+$row_shipping['price'], 2, ".", ","); ?>


	<?php $_SESSION['totalamount']=$totAmount; ?>	</td>


  </tr>


  <tr>


    <td class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td class="fieldcell" style="padding-top:10px;">&nbsp;</td>


    <td align="center" class="fieldcell" style="padding-top:10px;"><a href="javascript:returnTosearch();">Continue Shopping</a></td>


    <td colspan="2" align="center" class="fieldcell" style="padding-top:10px;">


	<a href="payment/payment.php" target="_blank">


	Checkout</a></td>


  </tr>


</table>


</form>








<?php		


	 $this->DBDisconnect();


	 return $result;


  }	 


}





// Add Item to the cart





function AddItem($itemId, $qty)


{


$cartId = $this->GetCartId();


$result = $this->CustomQuery("SELECT COUNT(*) FROM tbl_cart WHERE cookieId = '".$cartId."' AND itemId = $itemId");


$row = mysql_fetch_row($result);


$numRows = $row[0];





	if($numRows == 0)


	{


		 $insert = 'cookieId,itemId,qty';


		 $values = "'".$cartId."','".$itemId."','".$qty."'"; 	


		 $result2 = $this->InsertRecord('tbl_cart',$insert,$values);


		   if($result2) 


				{


				$_SESSION['cartItem'] = 'set';


				echo 'Item Added to Cart';


				}else{


				echo 'Unable to add item';


				}


	}


	else


	{


	$this->UpdateItem($itemId, $qty);


	}


}








// Remove Item to the cart


function RemoveItem($itemId)


{


  $cartId = $this->GetCartId();


  $result = $this->CustomQuery("DELETE FROM tbl_cart WHERE cookieId = '".$cartId."' AND itemId = '".$itemId."'");


  if($result) 


    {


	 echo 'Item Removed';


	}else{


	 echo 'Unable to remove item';


	}


}





// Update Item to the cart


function UpdateItem($itemId, $qty)


{


  $cartId = "'".$this->GetCartId()."'";


  $query = "UPDATE tbl_cart SET qty = ".$qty." WHERE cookieId=".$cartId." AND itemId=".$itemId;


  //exit;


  $result = $this->CustomQuery($query);


  if($result) 


    {


	 echo 'Item updated';


	}else{


	 echo 'Unable to update item';


	}





}





// Get cart Id


function GetCartId()


{





	if(isset($_COOKIE["cartId"]))


	{ return $_COOKIE["cartId"]; }


	else


	{


	session_start();


	setcookie("cartId", session_id(), time() + ((3600 * 24) * 30));


	return session_id();


	}


}





function downloadVerify()


{


  $verify = $_GET['verify'];


  $currentdate = date('Y-m-d h:i:s');


  $Query = "SELECT * FROM tbl_download WHERE `verificationkey`='".$verify."' AND expireDate >='".$currentdate."'";


  $result = $this->CustomQuery($Query);


	


	 $this->DBDisconnect();


	 return $result;


}





### Add Submenu





function addMenu($mainId)


{


  $subPage = $_POST['subPage'];





     $result1 = $this->GetRecord('tbl_contents','contId',$subPage);


	 $row1 = mysql_fetch_object($result1);





     $mtitle = $row1->contTitle;


	 $mlink  = $row1->pgname;





  if($_POST['qryStr']){


  $mlink = $mlink.$_POST['qryStr'];


  }


  


  $values = "'".$mainId."','".$mtitle."','".$mlink."'";


  $result = $this->InsertRecord('tbl_menus','menuId,menuTitle,menuLink',$values);


  


  return $result;  


}





### Edit Submenu





function editMenu($mainId,$subId)


{





   $subPage = $_POST['subPage'];





     $result1 = $this->GetRecord('tbl_contents','contId',$subPage);


	 $row1 = mysql_fetch_object($result1);





     $mtitle = $row1->contTitle;


	 $mlink  = $row1->pgname;





  if($_POST['qryStr']){


  $mlink = $mlink.$_POST['qryStr'];


  }


  


  $values = $mainId."^".$mtitle."^".$mlink;


  $result = $this->MultipleUpdateRecord('tbl_menus','menuId,menuTitle,menuLink',$values,'submId',$subId);


  return $result; 


}











### Delete Submenu





function deleteMenu($id)


{


  $result = $this->DeleteRecord('tbl_menus','submId',$id);


  return $result;


}











### Main menu Status








function MenuStatus($id,$do1,$do2)


{


  


 $Query  = "UPDATE `tbl_contents` SET `menuactive`='$do1' WHERE `menuactive`='$do2' AND `contId`='$id'";


 $result = $this->CustomQuery($Query);


  return $result;


  


}








#### function to get page information ####


function getpdfList()


{


	$this->connectToDB();


	


	 $result=$this->fetchAllRecord('tbl_pdfs');


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function uploadpdf()


{


$fileuploader = new fileUploader();





	$this->connectToDB();


	


   $pdf          = 'pdFfile';


   $target_path  = '../uploadedpdf/';


   $pdfcount     = $_POST['pdfcount'];


   $mkdefault    = $_POST['defaultpdF']-1;


   $upMsg        = '';


   $insertStatus = '';





for($i=0; $i<$pdfcount; $i++)


{


  	


   $updresult = $fileuploader->uploadfile($pdf,$target_path,$i);





   $Xplode   = explode(',',$updresult);


   $pdfPath  = $Xplode[0];           // encoded url


   $pdfPath1 = addslashes(urldecode($pdfPath));   


   $pdfName1 = $Xplode[1];


   $pdfsize  = $Xplode[2];  


   $upMsg   .= $Xplode[3];








    if(empty($pdfPath1))


    { $pdfPath1 = "0";}


 


    if(empty($pdfName1))


    { $pdfName1 = "0";}   





    if(empty($pdfPath1))


    { $pdfPath1 = "0";}


 





    if(empty($pdfsize))


    { $pdfsize = "0";} 





    if($mkdefault == $i)


	{ $default = '1'; } else { $default = '0'; }


	


	


		$chkdefault = "SELECT COUNT(pdfdefault) AS totRowz FROM `tbl_pdfs` WHERE `pdfdefault`='1'";


		$Chkresult = $this->CustomQuery($chkdefault);


		$rowz = mysql_fetch_array($Chkresult);


		$num = $rowz['totRowz'];


	


	if($num > 0)


	{ $default = '0'; }


 	


	


   $insert   = 'pdfname,pdfpath,pdfsize,pdfdefault';


   $values   = "'".$pdfName1."','".$pdfPath1."','".$pdfsize."','".$default."'";


	


   $result=$this->InsertRecord('tbl_pdfs',$insert,$values);


	


	   if(!$result)


	    {


          $insertStatus .= $i.',';


		}


    }	


		


	 $this->DBDisconnect();


	 return $insertStatus;


}





#### function to get page information ####


function getpdfdetails($offset,$limit)


{


	$this->connectToDB();


	


	 $result=$this->fetchRecord('tbl_pdfs', $offset, $limit);


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}





### Delete Submenu





function deletepdf($id)


{


  $result = $this->DeleteRecord('tbl_pdfs','pdfId',$id);


  return $result;


}








#### function to upload reports documents ####


function uploadreportspdf()


{


$fileuploader = new fileUploader();





	$this->connectToDB();


	


   $target_path  = '../reportdocs/';        


   $upMsg        = '';


   $insertStatus = '';





   $partCounter = 1;


  





do{





  $loopCounter = $_POST['doccount'.$partCounter];


  $pdf = '';


  $pdf = 'pdFfile'.$partCounter;


  


for($i=0; $i<$loopCounter; $i++)


{


  	


   $updresult = $fileuploader->uploadfile($pdf,$target_path,$i);





   $Xplode   = explode(',',$updresult);


   $pdfPath  = $Xplode[0];           // encoded url


   $pdfPath1 = addslashes(urldecode($pdfPath));   


   $pdfName1 = $Xplode[1];


   $pdfsize  = $Xplode[2];  


   $upMsg   .= $Xplode[3];








    if(empty($pdfPath1))


    { $pdfPath1 = "0";}


 


    if(empty($pdfName1))


    { $pdfName1 = "0";}   





    if(empty($pdfPath1))


    { $pdfPath1 = "0";}


 





    if(empty($pdfsize))


    { $pdfsize = "0";} 





   $insert   = 'partnum,reportdoc,docpath,docsize';


   $values   = "'".$partCounter."','".$pdfName1."','".$pdfPath1."','".$pdfsize."'";


	


   $result=$this->InsertRecord('tbl_reportdocs',$insert,$values);


	


	   if(!$result)


	    {


          $insertStatus .= $i.',';


		}


    }	


		


	 $this->DBDisconnect();


     $partCounter = $partCounter+1;


}


while($partCounter <= 5);


return $insertStatus;


}





### Delete report documents





function deletereportdocs($id)


{


  $result = $this->DeleteRecord('tbl_reportdocs','docId',$id);


  return $result;


}








#### function to get page information ####


function getUsersList($offset,$limit)


{


	$this->connectToDB();


	


	 $result=$this->fetchRecord('tbl_members', $offset, $limit);


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get user information by user id####


function getUserInfo($id)


{


	$this->connectToDB();


	


	 $result=$this->GetRecord('tbl_members', 'uid', $id);


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("usersList.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}





#### function to get user information by username####


function getUserInfoByUsername($id)


{


	$this->connectToDB();


	


	 $result=$this->GetRecord('tbl_members', 'username', $id);


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("index.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function getUserverification($key,$id)


{


	 $this->connectToDB();


	 $result=$this->CustomQuery("SELECT * FROM tbl_members WHERE uid=".$id." AND verificationkey='".$key."'");


	 $this->DBDisconnect();


	 return $result;


}








#### function to add user ####


function addUser()


{


	$this->connectToDB();


	


   if(isset($_POST['addUser']))


   {


      $username = $_POST['username'];


	  $password = $_POST['pwd'];


	  $fname    = $_POST['fname'];


      $surname  = $_POST['surname'];


	  $email 	= $_POST['email'];


	  $dfone    = $_POST['dfone'] ;	  


      $celfone 	= $_POST['celfone'];


	  $bday 	= $_POST['bday'];


	  $bmonth   = $_POST['bmonth'];   


      $byear 	= $_POST['byear'];


	  $dob      = $bday.'/'.$bmonth.'/'.$byear;


	  $street 	= stripslashes($_POST['street']);


	  $city    	= $_POST['city']; 


	  $state 	= $_POST['state'];


	  $country  = $_POST['country'];   


      $gender	= $_POST['gender'];


	  $mstatus	= $_POST['mstatus'];


	  $kids   	= $_POST['nokids'];


	  $occup    = $_POST['occupation'];	  


	  $kidsAge 	= '';


	  $kidsSex 	= '';


	  $occupation = stripslashes($_POST['occupation']); 	  


	  $acctState   	= $_POST['acctState'];	  


	  


	   if($kids == 'yes'){


    	  $kidsAge 	.= implode(',',$_POST['kidAge']);


	      $kidsSex 	.= implode(',',$_POST['kidSex']);


       }





	  


	 $insert = 'username,pwd,fname,surname,email,dfone,mfone,dob,streetnum,city,state,country,gender,martialstatus,kids,kidsage,kidssex,occupation,status';


	 $values = "'$username','$password','$fname','$surname','$email','$dfone','$celfone','$dob','$street','$city','$state','$country','$gender','$mstatus','$kids','$kidsAge','$kidsSex','$occup','$acctState'";


	 $table = 'tbl_members';


	 


	 $insertion = $this->InsertRecord($table, $insert, $values);


	 


	 if($insertion)


	   {


	     header("location:usersList.php");


	   }


	 else{


	     header("location:addUser.php?msg=Failure");


	 }


	    


   }





}





#### function to add user ####


function editUser($id)


{


	$this->connectToDB();


	


   if(isset($_POST['editUser']))


   {


      $username = $_POST['username'];


	  $password = $_POST['pwd'];


	  $fname    = $_POST['fname'];


      $surname  = $_POST['surname'];


	  $email 	= $_POST['email'];


	  $dfone    = $_POST['dfone'] ;	  


      $celfone 	= $_POST['celfone'];


	  $bday 	= $_POST['bday'];


	  $bmonth   = $_POST['bmonth'];   


      $byear 	= $_POST['byear'];


	  $dob      = $bday.'/'.$bmonth.'/'.$byear;


	  $street 	= stripslashes($_POST['street']);


	  $city    	= $_POST['city']; 


	  $state 	= $_POST['state'];


	  $country  = $_POST['country'];   


      $gender	= $_POST['gender'];


	  $mstatus	= $_POST['mstatus'];


	  $kids   	= $_POST['nokids'];


	  $kidsAge 	= '';


	  $kidsSex 	= '';


	  $occupation = stripslashes($_POST['occupation']); 	  


	  $acctState   	= $_POST['acctState'];	  


	  


	   if($kids == 'yes'){


    	  $kidsAge 	.= implode(',',$_POST['kidAge']);


	      $kidsSex 	.= implode(',',$_POST['kidSex']);


       }


	      	  


	 $insert = 'username,pwd,fname,surname,email,dfone,mfone,dob,streetnum,city,state,country,gender,martialstatus,kids,kidsage,kidssex,occupation,status';


	 $values = $username.'^'.$password.'^'.$fname.'^'.$surname.'^'.$email.'^'.$dfone.'^'.$celfone.'^'.$dob.'^'.$street.'^'.$city.'^'.$state.'^'.$country.'^'.$gender.'^'.$mstatus.'^'.$kids.'^'.$kidsAge.'^'.$kidsSex.'^'.$occupation.'^'.$acctState;


	 $table = 'tbl_members';


	 


	 $insertion = $this->MultipleUpdateRecord($table, $insert, $values, 'uid' ,$_GET['eId']);


	 


	 if($insertion)


	   {


	     header("location:usersList.php");


	   }


	 else{


	     header("location:editUser.php?eId=".$_GET['eId']."&msg=Failure");


	 }


	    


   }





}





#### function to add user ####


function editUserAcct($id)


{


	$this->connectToDB();


	


   if(isset($_POST['Update']))


   {


      $username = $_POST['username'];


	  $password = $_POST['pwd'];


	  $fname    = $_POST['fname'];


      $surname  = $_POST['surname'];


	  $email 	= $_POST['email'];


	  $dfone    = $_POST['dfone'] ;	  


      $celfone 	= $_POST['celfone'];


	  $bday 	= $_POST['bday'];


	  $bmonth   = $_POST['bmonth'];   


      $byear 	= $_POST['byear'];


	  $dob      = $bday.'/'.$bmonth.'/'.$byear;


	  $street 	= stripslashes($_POST['street']);


	  $city    	= $_POST['city']; 


	  $state 	= $_POST['state'];


	  $country  = $_POST['country'];   


      $gender	= $_POST['gender'];


	  $mstatus	= $_POST['mstatus'];


	  $kids   	= $_POST['nokids'];


	  $kidsAge 	= '';


	  $kidsSex 	= '';


	  $occupation = stripslashes($_POST['occupation']); 	  


	  $acctState   	= 'active';	  


	  


	  


	  


	   if($kids == 'yes'){


    	  $kidsAge 	.= implode(',',$_POST['kidAge']);


	      $kidsSex 	.= implode(',',$_POST['kidSex']);


       }


	      	  


	 $insert = 'username,pwd,fname,surname,email,dfone,mfone,dob,streetnum,city,state,country,gender,martialstatus,kids,kidsage,kidssex,occupation,status';


	 $values = $username.'^'.$password.'^'.$fname.'^'.$surname.'^'.$email.'^'.$dfone.'^'.$celfone.'^'.$dob.'^'.$street.'^'.$city.'^'.$state.'^'.$country.'^'.$gender.'^'.$mstatus.'^'.$kids.'^'.$kidsAge.'^'.$kidsSex.'^'.$occupation.'^'.$acctState;


	 $table = 'tbl_members';


	 


	 $insertion = $this->MultipleUpdateRecord($table, $insert, $values, 'uid' ,$_SESSION['uid']);


	 return $insertion;  


   }





}











#### function to get add page ####


function delPage($id)


{


	$this->connectToDB();


	


	 $result=$this->DeleteRecord('tbl_contents', 'contId', $id);


	   if(!$result)


	    {


          echo '<script>alert("Error deleting page");</script';


		  echo '<script>window.open("listpages.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}





#### function to get edit page content ####


function editContent($id)


{





	$this->connectToDB();


	


	$pgName = $_POST['hidfname'];


	


	 $content = htmlentities(stripslashes($_POST['FCKeditor']));	 	 


	


	 $result=$this->ModifyRecord('tbl_contents', 'content', $content, 'contId' ,$id);


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function getCountryList()


{


	$this->connectToDB();


	


	 $result=$this->fetchAllRecord('tbl_countries');


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("listpages.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}








#### function to get page information ####


function getStatesList()


{


	$this->connectToDB();


	


	 $result=$this->fetchAllRecord('tbl_states');


	   if(!$result)


	    {


          echo '<script>alert("Error finding page");</script';


		  echo '<script>window.open("listpages.php","_parent");</script>';


		}


	 $this->DBDisconnect();


	 return $result;


}





#### Get Seo Data





function getdataSEO($page)


{





	$this->connectToDB();


	


	 if($page != '')


	  {


     $result=$this->GetRecord('tbl_seo','pgId',$page);


      }


	 if($page == '') 


	  {


     $result=$this->fetchAllRecord('tbl_seo');	  


	  }


	  


	  


	 $this->DBDisconnect();


	 return $result;


}








#### Update Seo Data





function updateSEO()


{





	$this->connectToDB();


	


	 $pgId = $_POST['pgId'];


	 $title  = $_POST['title'];


	 $keywords = $_POST['keywords'];


	 $descrip = $_POST['description'];


	


	$Query = "UPDATE tbl_seo SET title='$title',keywords='$keywords',description='$descrip' WHERE pgId='$pgId'";


	$result=$this->CustomQuery($Query);


    


     if(mysql_affected_rows() < 1)


       {


	   


	     $inserts = "title,pgId,keywords,description";


		 $values  = "'$title','$pgId','$keywords','$descrip'";


	      


	     $Query2 = $this->InsertRecord('tbl_seo',$inserts,$values);	   


	   


	   }








	 $this->DBDisconnect();


	 return $result;


}








#### function to set approval ####


function Approve($id,$val)


{


	$this->connectToDB();


	$result=$this->CustomModify("update listings set approved = '".$val."' where id=$id");


	


	$this->DBDisconnect();


	return $result;


}


#### function to get listings approved type "yes" or "no" ####


function GetListingByType($type)


{


	$this->connectToDB();


	$result=$this->CustomQuery("SELECT * from listings where approved = '".$type."'");


	$this->DBDisconnect();


	return $result;


}


#### function to get listings by category ####


function GetListingByCat($cat)


{


	$this->connectToDB();


	$result=$this->CustomQuery("SELECT * from listings where category = '".$cat."'");


	$this->DBDisconnect();


	return $result;


}


#### function to get listings filter by category and approvel####


function GetListing($cat , $type)


{


	$this->connectToDB();


	$result=$this->CustomQuery("SELECT * from listings where category = '".$cat."' and approved = '".$type."'");


	$this->DBDisconnect();


	return $result;


}


#### function to get listings filter by category and approvel####


function GetListingById($id)


{


	$this->connectToDB();


	$result=$this->CustomQuery("SELECT * from listings where id= '".$id."'");


	$this->DBDisconnect();


	return $result;


}





#### Search Listings####


function SearchListings($srch)


{


	$this->connectToDB();


    if($srch == "All")


    $result=$this->CustomQuery("SELECT * from listings "  );


    else


	$result=$this->CustomQuery("SELECT * from listings where listing like '%".$srch."%' or title like '%".$srch."%' or Category like '%".$srch."%' "  );


	$this->DBDisconnect();


	return $result;


}





#### Search Listings####


function SearchListingsById($srch , $id)


{


	$this->connectToDB();


	$result=$this->CustomQuery("SELECT * from listings where (listing like '%".$srch."%' or title like '%".$srch."%' or Category like '%".$srch."%') and (id in (".$id.")) "  );


	$this->DBDisconnect();


	return $result;


}





####Get Seetings####


function GetSettings()


{


	$this->connectToDB();


	$result=$this->CustomQuery("SELECT * from settings ");


	$this->DBDisconnect();


	return $result;


}


#### function toEdit settings ####


function EditSettings($imgsize,$limit,$display)


{


	$this->connectToDB();


	


	$result=$this->CustomModify("update settings set Imgsize = '".$imgsize."' , explimit = '".$limit."' , datedisplay = '".$display."' where id=1");


	


	$this->DBDisconnect();


	return $result;


}


#### function to set approval ####


function Login($user,$password)


{


	$this->connectToDB();


	$result=$this->CustomQuery("SELECT id from user where Username = '".$user."' and Password = '".$password."' ");


	


	$this->DBDisconnect();


	return $result;


}





#### function to update listings


function EditListings($id,$fname,$lname,$title,$listings,$cat,$phone,$email,$img,$expdate,$displaydate)


{


	$this->connectToDB();


	if($img == "")


	$query = "update listings set first = '".$fname."' , last = '".$lname."' , email = '".$email."' , phone = '".$phone."' , title = '".$title."' , Category =  '".$cat."' , listing = '".$listings."' ,expirydate = '".$expdate."',displaydate = '".$displaydate."' where id=$id";


	else 


	$query = "update listings set first = '".$fname."' , last = '".$lname."' , email = '".$email."' , phone = '".$phone."' , title = '".$title."' , Category =  '".$cat."' , listing = '".$listings."' ,imgfile = '".$img."',expirydate = '".$expdate."',displaydate = '".$displaydate."' where id=$id";


	





	$result=$this->CustomModify($query);


	


	


	$this->DBDisconnect();


	return $result;


	


}


function GetLogininfo($id)


{


	$this->connectToDB();


	$result=$this->CustomQuery("SELECT *  from user where id= $id ");


	


	$this->DBDisconnect();


	return $result;


	


}





function UpdateLogininfo($id,$user,$pwd)


{


	//echo"update user set Username= '".$user."' , Password= '".$pwd."'  where id=$id";


	$this->connectToDB();


	$result=$this->CustomModify("update user set Username= '".$user."' , Password= '".$pwd."'  where id=$id");


	


	$this->DBDisconnect();


	return $result;


}





function InsertUser($name,$course,$dept,$feepaid,$balance,$stdate,$enddate,$dob)


{


    $getID = $this->GetLatestID();


	$id = $getID[0]["id"]+1;


	$registration = "GFU".substr($dob,0,2).substr($dob,3,2).substr($dob,6).$id;


	$this->connectToDB();


	$table = "student";


	$insert = "Registration,`Name`,Course,Department,FeePaid,BalanceFee,StartDate,EndDate,Dateofbirth";


	$values = "'$registration','$name','$course','$dept',$feepaid,$balance,'$stdate','$enddate','$dob'";





	$result = $this->InsertRecord($table,$insert,$values);


	$this->DBDisconnect();


	return $result;


}





function Searchuser($reg)


{





	$this->connectToDB();


	$result=$this->CustomQuery("SELECT id  from student where Registration='".$reg."'");


	$this->DBDisconnect();


	return $result;


}


/*function login($uname,$pwd)


{


   $this->connectToDB();


	$result=$this->CustomQuery("SELECT id  from user  where Username='".$uname."' and Password = '".$pwd."'");


	$this->DBDisconnect();


	return $result;


}*/


}





?>