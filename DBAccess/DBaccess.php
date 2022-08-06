<?php
class DBAccess {

      var $DBlink;
      var $Result;
      var $x;
      function connectToDB()
      {
        $this->DBlink = mysql_pconnect( DBSERVER, DBUSER,DBPASSWORD);
          if (!$this->DBlink)
             die("Could not connect to mysql...........".mysql_error());
          mysql_select_db( DBNAME, $this->DBlink)
             or die( "Couldn't connect to database : ".mysql_error() );
      }
      function connectToDBOverLoad($ServerName,$UserName, $Password, $DBName)
      {
        $this->DBlink = mysql_pconnect( $ServerName, $UserName, $Password );
          if (!$this->DBlink)
             die("Could not connect to mysql");
          mysql_select_db( $DBName, $this->DBlink)
             or die( "Couldn't connect to database : ".mysql_error() );
      }
      function testconnection()
      {
      	if (!$this->DBlink)
      	{
             die("Could not connect to mysql : ".mysql_error());
          mysql_select_db( $DBName, $this->DBlink)
             or die( "Couldn't connect to database : ".mysql_error() );
      	}
      	else
      	{
      		echo "Congrats";
      	}
      }

     // function to Get the Record from a table
     
	  function fetchRecord($table, $offset, $limit)
      {
          $this->connectToDB();
		  $this->Result = mysql_query ( "SELECT * FROM $table LIMIT $offset, $limit");
          if ( ! $this->Result )
          die( "getRow fatal error: ".mysql_error() );
          return $this->Result;
      }
     // function to Get the All Record from a table
     
	  function fetchAllRecord($table)
      {
          $this->connectToDB();
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
	      $this->connectToDB();
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
	      $this->connectToDB();
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
		   $this->connectToDB();
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
            $this->connectToDB();
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
           
		   $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='".$fval."' && $fnm1='".$fval1."'" , $this->DBlink );
           if ( ! $this->Result )
		       die( "getRow fatal error: ".mysql_error() );
		   
		  
		     //echo   mysql_num_rows( $this->Result );
           return $this->Result;
      }

// OVERLOAD but with num of rows
		function ReturnNumRow($table, $fnm, $fval, $fnm1, $fval1, $required)
		{
			$this->Result = mysql_query ( "SELECT $required FROM $table WHERE $fnm='$fval' && $fnm1='$fval1'" , $this->DBlink );
		    if ( ! $this->Result )
		       die( "getRow fatal error: ".mysql_error() );
		    
     		$back = mysql_num_rows($this->Result);
			
		    return $back;
		
		}


      //getting total no of a particular record
      function GetNumberOfRecords($table, $fnm, $fval)
      {
		   $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm = '$fval'" , $this->DBlink );
		   
           if ( ! $this->Result )
           die( "getRow fatal error: ".mysql_error() );
           return mysql_num_rows( $this->Result );
	  }

       //getting total no of a particular record
       function OverloadsGetNumberOfRecord($table, $fnm, $fval,$fnm1, $fval1)
       {
            $this->connectToDB();
			
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
		    $this->Result = mysql_query ( "SELECT $required FROM $table WHERE $fnm='$fval'" , $this->DBlink );
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
		    $this->Result = mysql_query ( "SELECT $required FROM $table " , $this->DBlink );
		    if ( ! $this->Result )
		        return false;
		
		    while($row= mysql_fetch_array( $this->Result )){
		        $back = $row["$required"];
		    }
		    return $back;
		}
		
		function OverloadsGetDistinctRecordByCriteria($table, $required)
		{
			
			
		    $this->Result = mysql_query ( "SELECT DISTINCT $required FROM $table " , $this->DBlink );
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
	      $this->connectToDB();
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
              $this->connectToDB();
		    //echo "INSERT INTO $table ($insert) VALUES($vals)";
			//exit;
			  $this->Result = mysql_query("INSERT INTO $table ($insert) VALUES($vals)");
		      return $this->Result;
		}
		
		
		//function to retrieve a single field
		function GetSingleField($table, $fnm, $fval, $required)
		{
		    	
			$this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'" , $this->DBlink );
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
			$this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval' && $fnm1='$fval1'" , $this->DBlink );
		    if ( ! $this->Result )
		       die( "getRow fatal error: ".mysql_error() );
		    while($row= mysql_fetch_array( $this->Result )){
		        $back = $row["$required"];
		        
		    }
		    return $back;
		
		}
		
		function getSingleFieldCustomQuery($Query_C){
		
			$this->Result = mysql_query ($Query_C , $this->DBlink );
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
		    $this->Result = mysql_query ( "SELECT * FROM $table WHERE $fnm='$fval'" , $this->DBlink );
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
	      $this->connectToDB();
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
		    
			$query=$Cquery;
			
		    $this->Result = mysql_query($query, $this->DBlink);
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
		    $query="UPDATE $table set $fnm1='$fval1' WHERE $fnm='$fval'&&$fnm0='$fval0'";
		    $this->Result = mysql_query($query, $this->DBlink);
		    if (! $this->Result)
		       die("updateOrg update error: ".mysql_error() );
		
		}

		//fucntion to modify record  
		function ModifyMultiRecord($table, $fnm, $fval, $fnm1, $fval1, $fnm2, $fval2)
		{
		    $this->connectToDB();
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
		    $this->connectToDB();	
			$query="DELETE FROM $table WHERE $frn='$fval' && $frn1='$fval1'";
		    $this->Result = mysql_query($query);
			return $this->Result;		
		}
		
		//delete function
		function DeleteRecord($table, $frn, $fval)
		{
		    $this->connectToDB();		
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
		   
			$query = "Delete from $table Where $frn=$fval";
			//echo $query;
		    $this->Result = mysql_query($query, $this->DBlink);
			
		    if (! $this->Result)
		       return false;
			   if(mysql_affected_rows($this->DBlink) > 0)
			      return true;
			   else
				  return false;
		       
		     return true;
		
		}
		
		function CustomQuery($Query_C)
		{
            $this->connectToDB();
		    $Query = "$Query_C";
			
			$this->Result = mysql_query($Query_C);
		    return $this->Result;
		}
		
		
		
		//funtion to free and close sql result and connection
		function DBDisconnect()
		{
			if(!$this->Result){}else{
		   }
		    mysql_close($this->DBlink);
		
		}
		
}
?>