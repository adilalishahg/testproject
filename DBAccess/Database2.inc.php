<?php





	//error_reporting(E_ALL & ~E_NOTICE);


	session_start();




    $parts=pathinfo($_SERVER["SCRIPT_NAME"]);


    $part2 = dirname($parts['dirname']);


 





    $Xplode = explode('administrator',$part2);


    $size   = sizeof($Xplode);





    if($size >= 1)


    {


     $path = '../';


    }else{





     $path = '';


    }





	include_once("configuration/config.php");








	include_once("alibs/Smarty.class.php");


	//include_once("../encrypt.php");


	$smarty = new Smarty();








	define("DB_NAME",$dbs);


	define("DB_HOST",$dbname);


	define("DB_USER",$dbuser);


	define("DB_PASS",$dbpasswd);


	//include_once("util.php");





	


	class Database{


		


		var $rs=0;


		


		var $dbh;


    	var $database_name;


    	var $database_host;


    	var $database_user;


    	var $database_pass;


		var $Result;


		


		//Create Class Object				


		function Database(){


			$database_name = DB_NAME;


        	$database_host = DB_HOST;


        	$database_user = DB_USER;


        	$database_pass = DB_PASS;


    


        	$this->database_name = $database_name;


        	$this->database_host = $database_host;


        	$this->database_user = $database_user;


        	$this->database_pass = $database_pass;


        	return 1;


		}		


		


		//Create New Database


		function create_db () {


     	   $database_name = $this->database_name;


	        return mysql_create_db($database_name);


    	}


    	


    	


		//Select Database


	     function select_db () {


     	   $database_name = $this->database_name;


	        return mysql_select_db($database_name);


	    }


	    


	    //Connect to Database


	    function connect () {


     	   $host = $this->database_host;


           $username = $this->database_user;


           $password = $this->database_pass;


           $this->dbh = mysql_connect($host, $username, $password);


           $this->select_db();


           return $this->dbh;


    	}	


    	


		//Query Database and Return Resource (For Selection Purpose)


		function query($sql){


			//echo "<BR>"  . "-->  $sql<BR>";


			$this->rs=mysql_query($sql,$this->dbh);			


			if($this->rs){


				return true;


			}


			else {


				echo "<BR>" . mysql_error() . "-->  $sql<BR>";	


				$emsgyz = mysql_error() . " " . $sql; 


				//@mail("muhdsajjid@hotmail.com","Error inside Jewellery Site: - AdminSelect",$emsgyz,"From:checkit@checklist.com");


				return false;


			}


		}


		


		//Query Database and Return True/False (For Insert/Update/Delete)


		function execute($sql){


			//echo "<BR>"  . "-->  $sql<BR>";


			if(mysql_query($sql,$this->dbh)){


				return true;


			}


			else {


				echo "<BR>" . mysql_error() . "<BR>";	


				$emsgyz = mysql_error() . " " . $sql; 


				//@mail("muhdsajjid@hotmail.com","Error inside : - AdminExecute",$emsgyz,"From:checkit@checklist.com");


				


				


				return false;


			}		


			return false;					


		}


		


		//Fetch Single Record


		function fetch_row(){


			return mysql_fetch_row($this->rs);


		}		


		


		//Fetch All Records


		function fetch_all(){


			$ret= array();


			$num = $this->get_num_rows();


			


			for($i=0;$i<$num;$i++){


				array_push($ret,$this->fetch_row());


			}		


			return $ret;


		}


		


		//Fetch Number of Rows Returned


		function get_num_rows(){


			if($this->rs)


				return mysql_num_rows($this->rs);


			else


				return 0;


		}


		


		//Move in Rows One by One


		function move_to_row($num){


			if($num>=0 && $this->rs){


				return mysql_data_seek($this->rs,$num);


			}


			return 1;


		}											


		


		//Fetch Number of Columns.


		function get_num_columns(){


			return mysql_num_fields($this->rs);


		}


					


		


		//Fetch Column Names					


		function get_column_names(){


			$nofields= mysql_num_fields($this->rs);


			$fieldnames=array();


			for($k=0;$k<$nofields;$k++)


			{


				array_push($fieldnames,mysql_field_name($this->rs,$k));


			}


			return $fieldnames;


		}			


		


		//Fetch Last Error Produced by MySql (Use for debuging purpose)


		 function debug () {


     	   echo mysql_errno().": ". mysql_error ()."";


   		 }


   		


		


		//Fetch List of All Db Tables


    	function list_tables () {


     	   $database_name = $this->database_name;


        	return mysql_list_tables($database_name);


    	}


    	


    	 //Fetch MySql Recent Inserted Id


   		 function insert_id () {


     	   return mysql_insert_id ();


    	}


    	


    	//Fetch Records as an Array    	


    	function fetch_array ($res) {


          return mysql_fetch_array ($res);        


    	}


		//Fetch Single Record associative


		function fetch_row_assoc(){


			return mysql_fetch_assoc($this->rs);


		}


    	


    	//Fetch all record as an Associative Array


    	function fetch_all_assoc(){


			$ret= array();


			while ($row = mysql_fetch_assoc($this->rs)) {


				array_push($ret,$row);


			}					


			return $ret;


		}


		


		//Fetch single record as an Associative Array


		function fetch_one_assoc(){


			$ret= array();


			$ret = mysql_fetch_assoc($this->rs);


			return $ret;


		}


							


		//Fetch one cell from given query


		function  executeScalar($sql){


			$this->query($sql);


			$row = $this->fetch_row();


			return $row[0];


		}


		


		//Fetch 2 cell from given query


		function  executeTwise($sql){


			$this->query($sql);


			$row = $this->fetch_row();


			$temp = array();


			$temp[0] =  $row[0];


			$temp[1] =  $row[1];


			return $temp;


		}


		


		//Close Database Connection


    	function close(){


			mysql_close($this->dbh);


		}


		


		


     // function to Get the Record from a table


     


	  function fetchRecord($table, $offset, $limit)


      {


          $this->rs;


		  $this->Result = mysql_query ( "SELECT * FROM $table LIMIT $offset, $limit");


          if ( ! $this->Result )


          die( "getRow fatal error: ".mysql_error() );


          return $this->Result;


      }


     // function to Get the All Record from a table


     


	  function fetchAllRecord($table)


      {


          $this->rs;


		  //echo "SELECT * FROM $table";


		 // exit;


		  $this->Result = mysql_query ("SELECT * FROM $table");


          if ( ! $this->Result )


          die( "getRow fatal error: ".mysql_error() );


          return $this->Result;


      }


      //function to check the prexistance of a field


      function GetRecord($table, $fnm, $fval)


      {


	      $this->rs;


         //echo "SELECT * FROM $table WHERE $fnm='$fval'";


		 //exit;


		  


		  $this->Result = mysql_query ("SELECT * FROM $table WHERE $fnm='$fval'");


          if ( ! $this->Result )


          die( "getRow fatal error: ".mysql_error() );


          return $this->Result;


      }


	//function to check the prexistance of a field


      function GetRecordByLimit($table, $fnm, $fval, $offset, $limit)


      {


	      $this->rs;


          $this->Result = mysql_query ("SELECT * FROM $table WHERE $fnm='$fval' LIMIT $offset, $limit");


          if ( ! $this->Result )


          die( "getRow fatal error: ".mysql_error() );


          return $this->Result;


      }


      //function to check username and password


      function GetNumberOfRecordsOverloaded($table, $fnm, $fval, $fnm1, $fval1)


      {


	      // echo "SELECT * FROM $table WHERE $fnm='".$fval."' && $fnm1='".$fval1."'";


          // exit;


		   $this->rs;


		   $this->Result = mysql_query ("SELECT * FROM $table WHERE $fnm='".$fval."' && $fnm1='".$fval1."'");


           if ( ! $this->Result )


		       die( "getRow fatal error: ".mysql_error() );


		   


		     return $this->Result;


		     //echo   mysql_num_rows( $this->Result );


           //return mysql_num_rows( $this->Result );


      }


	  function GetNumberOfRecordsOverloadednew($table, $fnm, $fval)


      {


	       //echo "SELECT * FROM $table WHERE $fnm='".$fval."' && $fnm1='".$fval1."'";


           $this->rs;


		   $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='".$fval."' ");


           if ( ! $this->Result )


		       die( "getRow fatal error: ".mysql_error() );


		   


		     return $this->Result;


		     //echo   mysql_num_rows( $this->Result );


           //return mysql_num_rows( $this->Result );


      }





      //function to check username and password


      function GetMappedRecord($table, $fnm, $fval, $fnm1, $fval1)


      {


	       //echo "SELECT * FROM $table WHERE $fnm='".$fval."' && $fnm1='".$fval1."'";


           $this->rs;


		   $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='".$fval."' && $fnm1='".$fval1."'" );


           if ( ! $this->Result )


		       die( "getRow fatal error: ".mysql_error() );


		   


		  


		     //echo   mysql_num_rows( $this->Result );


           return $this->Result;


      }





// OVERLOAD but with num of rows


		function ReturnNumRow($table, $fnm, $fval, $fnm1, $fval1, $required)


		{


		    $this->rs;


			$this->Result = mysql_query ( "SELECT $required FROM $table WHERE $fnm='$fval' && $fnm1='$fval1'");


		    if ( ! $this->Result )


		       die( "getRow fatal error: ".mysql_error() );


		    


     		$back = mysql_num_rows($this->Result);


			


		    return $back;


		


		}








      //getting total no of a particular record


      function GetNumberOfRecords($table, $fnm, $fval)


      {


	       $this->rs;


		   $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm = '$fval'");


		   


           if ( ! $this->Result )


           die( "getRow fatal error: ".mysql_error() );


           return mysql_num_rows( $this->Result );


	  }





       //getting total no of a particular record


       function OverloadsGetNumberOfRecord($table, $fnm, $fval,$fnm1, $fval1)


       {


            $this->rs;


			


			$query = "SELECT * FROM $table WHERE $fnm='$fval'&& $fnm1='$fval1'";


			//exit;


			


			$this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'&& $fnm1='$fval1'" , $this->DBlink );


    		if ( ! $this->Result )


       			die( "getRow fatal error: ".mysql_error() );


    		return mysql_num_rows( $this->Result );


		}


		


		//function to get the manximum of all


		function GetRecordByCriteria($table, $fnm, $fval, $required)


		{


		    $this->rs;


		    $this->Result = mysql_query ( "SELECT $required FROM $table WHERE $fnm='$fval'");


		    if ( ! $this->Result )


		        return false;


		


		    while($row= mysql_fetch_array( $this->Result )){


		        $back = $row["$required"];


		    }


		    return $back;


		}





		//function to get the manximum of all


		function GetRecordByCriteriaOverloads($table, $required)


		{


		    $this->rs;


		    $this->Result = mysql_query ( "SELECT $required FROM $table ");


		    if ( ! $this->Result )


		        return false;


		


		    while($row= mysql_fetch_array( $this->Result )){


		        $back = $row["$required"];


		    }


		    return $back;


		}


		


		function OverloadsGetDistinctRecordByCriteria($table, $required)


		{


			


			$this->rs;


		    $this->Result = mysql_query ( "SELECT DISTINCT $required FROM $table ");


		    if ( ! $this->Result )


		        return false;


		


		    while($row= mysql_fetch_array( $this->Result )){


		        $back[] = $row["$required"];


		        


		    }


		   


		    return $back;


		}





		//function to update multiple data into the table


		function MultipleUpdateRecord($table, $insert, $values, $eId ,$id)


		{


	      $this->rs;


						$xplode1 = explode(',',$insert);


						$xplode2 = explode('^',$values);


						$size = sizeof($xplode1); 


						//var_dump($size);


						 $sql = "UPDATE $table SET ";


						   for($i=0; $i< $size; $i++)


						{


						if(!empty($values))


						{


						$sql .= $xplode1[$i]." = '".$xplode2[$i]."' ,";


						}


						}


						$sql = substr($sql, 0, -2); //Remove the last space and ,


						$sql .= " WHERE ".$eId."=".$id;  


						//echo $sql;


						//exit;


						//var_dump($fields);


								   $Result = mysql_query($sql) or die(mysql_error());


								   return $Result;


						//var_dump($sql);


								}		





		


		//function to insert data into the table


		function InsertRecord($table, $insert, $vals)


		{


            $this->rs;


		    //echo "INSERT INTO $table ($insert) VALUES($vals)";


			//exit;


			  $this->Result = mysql_query("INSERT INTO $table ($insert) VALUES($vals)");


		      return $this->Result;


		}


		


		


		//function to retrieve a single field


		function GetSingleField($table, $fnm, $fval, $required)


		{


		    $this->rs;	


			$this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'");


		    if ( ! $this->Result )


		{       


		return false;


		


		}


		    while($row= mysql_fetch_array( $this->Result )){


			


		        $back = $row["$required"];


		    }


		    return $back;


		}


		


		function OverloadsGetSingleField($table, $fnm, $fval, $fnm1, $fval1, $required)


		{


			$this->rs;


			$this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval' && $fnm1='$fval1'" );


		    if ( ! $this->Result )


		       die( "getRow fatal error: ".mysql_error() );


		    while($row= mysql_fetch_array( $this->Result )){


		        $back = $row["$required"];


		        


		    }


		    return $back;


		


		}


		


		function getSingleFieldCustomQuery($Query_C)


		{


		    $this->rs;


			$this->Result = mysql_query ($Query_C);


		    if ( ! $this->Result )


				return false;


		


		    while($row= mysql_fetch_array( $this->Result )){


			


		        $back = $row[0];


		    


		    }


		    


		    return $back;


		}


		


		


		//function to get an array of something


		function ArrayOfSingleField($table, $fnm, $fval, $required)


		{


		    $this->rs;


		    $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'");


		    if ( ! $this->Result )


		       die( "getRow fatal error: ".mysql_error() );


		    while($row= mysql_fetch_array( $this->Result )){


				


		        $RecArray[] = $row["$required"];


		    }


		    return $RecArray;


		


		}


		


		


		//function to modify an existing record


		function ModifyRecord($table, $fnm, $fval, $fnm1, $fval1)


		{


	      $this->rs;


			$query="UPDATE $table set $fnm='$fval' WHERE $fnm1='$fval1'";


			//echo $query;


		    //exit;


			


			$Result = mysql_query($query);


		    


	


		   // if (! $this->Result)


		    if (!$Result)


		       return false;


		    else      


		       return true;


		


		}


		


		//function to modify fields by passing query


		function CustomModify($Cquery)


		{


		    $this->rs;


			$query=$Cquery;


			


		    $this->Result = mysql_query($query);


		    if (! $this->Result)


		       return false;	


			   if(mysql_affected_rows($this->DBlink) > 0)


			      return true;


			   else


				  return false;


		       return true;


		}


		


		//fucntion to modify existing field with two where parammeters


		function OverloadsModifyRecord($table, $fnm, $fval, $fnm0, $fval0, $fnm1, $fval1)


		{


		    $this->rs;


		    $query="UPDATE $table set $fnm1='$fval1' WHERE $fnm='$fval'&&$fnm0='$fval0'";


		    $this->Result = mysql_query($query);


		    if (! $this->Result)


		       die("updateOrg update error: ".mysql_error() );


		


		}





		//fucntion to modify record  


		function ModifyMultiRecord($table, $fnm, $fval, $fnm1, $fval1, $fnm2, $fval2)


		{


		    $this->rs;


			$query="UPDATE $table set $fnm1='$fval1',$fnm2='$fval2' WHERE $fnm='$fval'";





		    $this->Result = mysql_query($query);


		    if (! $this->Result)


		       {


			   die("updateOrg update error: ".mysql_error() );


		       }else{


			   echo "<script>alert('Record Updated Successfully');</script>";


			   }


		


		   return $this->Result;


		}





		


		//function to delete a whole record


		function DeleteSingleRecord($table, $frn, $fval, $frn1, $fval1)


		{


		    $this->rs;	


			$query="DELETE FROM $table WHERE $frn='$fval' && $frn1='$fval1'";


		    $this->Result = mysql_query($query);


			return $this->Result;		


		}


		


		//delete function


		function DeleteRecord($table, $frn, $fval)


		{


		    $this->rs;		


		    $query="DELETE FROM $table WHERE $frn='$fval'";


			$this->Result = mysql_query($query);


/*		    if (! $this->Result){


			   echo "<script>alert('Record Deleting Failed');</script>";


		     }else{  


			   echo "<script>alert('Record Deleted Successfully');</script>";


		    }*/


			return $this->Result;


		}








	//function to delete a whole record


		function DeleteSetOfRecords($table, $frn, $fval)


		{


		     $this->rs;


			$query = "Delete from $table Where $frn=$fval";


			//echo $query;


		    $this->Result = mysql_query($query);


			


		    if (! $this->Result)


		       return false;


			   if(mysql_affected_rows() > 0)


			      return true;


			   else


				  return false;


		       


		     return true;


		


		}


		


		function CustomQuery($Query_C)


		{


            $this->rs;


		    $Query = "$Query_C";


			


			$this->Result = mysql_query($Query_C);


		    return $this->Result;


		}


					


	}// End of class





		function  checkEmail($email) {


		 if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {





		  return true;


		 }else{ return false; }


		}


	// Utility Functions			


	function sql_replace($str){


		$str2 = stripslashes($str);		


		//return mysql_real_escape_string($str2);		


		return mysql_real_escape_string($str2);		


	}


   //Convert time from AM/PM to 24hoours


   function convertTimeToMySQL($str){


     $str2 = date('H:i:s', strtotime($str));


     return $str2;


   }


   


   //Convert time from 24hoours to AM/PM


   function convertTimeFromMySQL($str){


     $str2 = date("g:i A", strtotime($str));;


     return $str2;


   } 
$db = new Database;	
$db->connect();
$query = "SELECT * FROM ".TBL_CONTACT;
    if($db->query($query) && $db->get_num_rows() > 0){$udata = $db->fetch_one_assoc();}
	date_default_timezone_set($udata['time_zone']);
	define("GEOCODE",$udata['google_coordinates']); echo $udata['google_coordinates'];
$db->close();


?>