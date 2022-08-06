<?php ob_start();	session_start();

   $parts = pathinfo($_SERVER["SCRIPT_NAME"]);

   $part2 = dirname($parts['dirname']);

    $Xplode = explode('administrator',$part2); 

	$ADD_DAYS=29;

	$LIMIT_DAYS=30;

	$ADD_DAYS2=59;

	$LIMIT_DAYS2=60;

    $size   = sizeof($Xplode);

    if($size == 1)

    {

     $path = '';

    }

	else if($size > 1){

     $path = '../';

    }

	else{

     $path = '';

    }

    include_once($path."configuration/config.php");

	//include_once("file:///D|/wamp/www/VMT_temp/administrator/commonfunctions.php");

    $path."alibs/Smarty.class.php";

	include_once($path."alibs/Smarty.class.php");

	$smarty = new Smarty();	

	$smarty->template_dir = $path."atpls";

	$smarty->compile_dir = $path."alibs/debug";

	$smarty->plugins_dir = array($path.'alibs/plugins');		

  // $_url = str_replace('/vmt/'.''.$_SERVER['REQUEST_URI']);

  // $_SESSION["URLTOGO"] =  'http://www.valleymedtrans.com/'.$_url;

	if($parts['basename']=='login.php' && isset($_SESSION['allow_print'])){

		if($_SESSION['allow_print']=='accessInFileAllowed'){

			echo '<script>location.href="'.$path.'index.php";</script>';	

		}

	}

   if($parts['basename'] != 'login.php' && $parts['basename'] != 'verify.php'){

	if(!isset($_SESSION['allow_print'])){

	   // header("Location: ".$path."login.php");

	    echo '<script>location.href="'.$path.'login.php";</script>';

		exit;

	}

	if($_SESSION['allow_print'] != 'accessInFileAllowed'){

	//header("Location: ".$path."login.php");

	    echo '<script>location.href="'.$path.'login.php";</script>';

	exit;

	}	

  }	 	

	$file		= $_SERVER["SCRIPT_NAME"];

	$break		= Explode('/', $file);				//Exploding it with '/'.

	$scriptName	= $break[count($break) - 1];		//Getting the script name.

  //  define('DB_DSN','mysql:host=172.16.0.3;dbname=vmt1');

	define("DB_NAME",$dbs);

	define("DB_HOST",$dbname);

	define("DB_USER",$dbuser);

	define("DB_PASS",$dbpasswd);

	//include_once("file:///D|/wamp/www/VMT_temp/administrator/DBAccess/util.php");

	$dbObject = new Database();

	$dbObject->connect();

	$dbObject->close();

	//These are the mail administrators.

	//$administrators = $dbObject->executeScalar("Select email from admin_emails where type=2");

	class Database{

		var $rs=0;

		var $dbh;

    	var $database_name;

    	var $database_host;

    	var $database_user;

    	var $database_pass;

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

			//print "<br> Temporary Shown: Be Patiences ... " . $sql;

			$this->rs=mysql_query($sql,$this->dbh);			

			if($this->rs){

				return true;

			}			

			else {

				echo "<BR>" . mysql_error() . "-->  $sql<BR>";	

				$_ip__ = $_SERVER['REMOTE_ADDR'];

				$HOST = $_SERVER['HTTP_HOST']; 

				$URI = $_SERVER['REQUEST_URI']; 

				$emsgyz = mysql_error() . " FOR " . $sql . "/r/n/r/n AT $HOST$URI BY $_ip__"; 

				//@mail("","Error inside ShopCart: - AdminSelect",$emsgyz,"From:checkit@checklist.com");

				return false;

			}

		}

		//Query Database and Return True/False (For Insert/Update/Delete)

		function execute($sql){

			//print "<br> Temporary Shown: Be Patiences ... " . $sql;

			if(mysql_query($sql,$this->dbh)){

				return true;

			}

			else {

				echo "<BR>" . mysql_error() . "-->$sql<BR>";	

				$_ip__ = $_SERVER['REMOTE_ADDR'];

				$HOST = $_SERVER['HTTP_HOST']; 

				$URI = $_SERVER['REQUEST_URI']; 

				$emsgyz = mysql_error() . " FOR " . $sql . "/r/n/r/n AT $HOST$URI BY $_ip__"; 

				//@mail("","Error inside ShopCart: - AdminExecute",$emsgyz,"From:checkit@checklist.com");

				return false;

			}		

			return false;					

		}

		//Fetch Single Record

		function fetch_row(){

			return mysql_fetch_row($this->rs);

		}

		//Fetch Single Record associative

		function fetch_row_assoc(){

			return mysql_fetch_assoc($this->rs);

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

   //Convert date from mm/dd/yy to yy/mm/dd

   function convertDateToMySQL($str){

     $str2 = explode('/',$str);

      //$yr = date('y');

	  //if($str2[2] > $yr){ $year = '19'.$str2[2]; }else{ $year = '20'.$str2[2]; }

      return $str2[2].'-'.$str2[0].'-'.$str2[1];

   }

   //Convert date from yy/mm/dd to mm/dd/yy

   function convertDateFromMySQL($str){

     $str2 = explode('-',$str);

     return $str2[1].'/'.$str2[2].'/'.$str2[0];

   } 

	function verify($var, $link)

	{

		if(isset($var) && $var!= '')

		{

			return true;

		}

		else

		{

			if($lin!='')

			{

				@header("Location:$link");

				return false;

			}

		}

	}	

	function debug($array)

	{

		echo "<pre>";

		print_r($array);

		exit;

	}

	function get_server_time()

	{

	$db = new Database;	

		$db->connect();

		$qtime = $db->query('SELECT NOW() AS tym');

		$get = $db->fetch_one_assoc();

		$xp = explode(' ',$get['tym']);

		$date = $xp[0];

		$time_required = $xp[1];

		$time_required2  = explode(':',$time_required);

		$time_required3 = ($time_required2[0]+2).':'.$time_required2[1].':'.$time_required2[2]; //server time plus two hours

		$time_required4 = $time_required2[0].':'.$time_required2[1].':'.$time_required2[2]; //fixed server time 

		$time1 = explode(':',$xp[1]);

		$timehr=$time1[0]-2;

		if($time1[0] > 2)

		{

			$timehr = $time1[0] - 2;

		}

		else

		{

		$timehr = 2 - $time1[0];

		}

		$timemin=$time1[1]+3;

		if($timemin>59)

		{

			$diff = $timemin - 59;

			$timehr = $timehr +1;

			$timemin = $diff;

		}

		$timesec=$time1[2];

		$timet=$timehr.":".$timemin.":".$timesec;

		$t=explode(':',$timet);

		$thr=$t[0]+2;

		$tin=$t[1]-3;

		$tsec=$t[2];

		$tt=$thr.":".$tin.":".$tsec;

		//$data = array($tt, $date);

		$data = array(date("H:i:s"), date("Y-m-d"));

		//$data = array($time_required4, $date);

		return $data;

	}

	function log_me()

	{

		$db = new Database;	

		$db->connect();

		if(verify($_SESSION['admuser']['admin_id'],"") )

		{

			if($_SESSION['admuser']['admin_level']!='0')

			{

				$user = $_SESSION['admuser']['admin_id'];

				$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

				 $qtime = $db->query('SELECT NOW() AS tym');

				 $get = $db->fetch_one_assoc();

				 $xp = explode(' ',$get['tym']);

				 $date = $xp[0];

				 $time=$xp[1];		

				$logQuery = "INSERT INTO  ".TBL_ALOG." SET

																		link = '$url',

																		time = '$time',

																		date = '$date',

																		user = '$user'";

				if($db->query($logQuery))

				{

					return true;

				}

				else

				{

					return false;

				}

			}

		}

		$db->close();

	}

$db = new Database;	

$db->connect();

$query = "SELECT * FROM ".TBL_CONTACT;

    if($db->query($query) && $db->get_num_rows() > 0){$udata = $db->fetch_one_assoc();}

	date_default_timezone_set($udata['time_zone']);

	define("GEOCODE",$udata['google_coordinates']);

$db->close();

function timetoseconds($time){

		$ep=explode(":",$time);

		if($ep[0]) $s0=$ep[0]*3600;

		if($ep[1]) $s1=$ep[1]*60;

		if($ep[2]) $s2=$ep[0];

		 return($s0+$s1+$s2);

		}

function secondsToTime($inputSeconds) {

    $secondsInAMinute = 60;

    $secondsInAnHour  = 60 * $secondsInAMinute;

    $hours = floor($inputSeconds / $secondsInAnHour);

    $minuteSeconds = $inputSeconds % $secondsInAnHour;

    $minutes = floor($minuteSeconds / $secondsInAMinute);

    $obj = array('hours'=>(int)$hours,'minutes'=>(int)$minutes);

    return $obj;}

function fulltime($inputSeconds) {

    $secondsInAMinute = 60;

    $secondsInAnHour  = 60 * $secondsInAMinute;

    $hours = floor($inputSeconds / $secondsInAnHour);

    $minuteSeconds = $inputSeconds % $secondsInAnHour;

    $minutes = floor($minuteSeconds / $secondsInAMinute);

    //$obj = array('hours'=>(int)$hours,'minutes'=>(int)$minutes);

    return (int)$hours.':'.(int)$minutes;}	

function secondsToTime2($inputSeconds) {

    $secondsInAMinute = 60;

    $secondsInAnHour  = 60 * $secondsInAMinute;

    $secondsInADay    = 24 * $secondsInAnHour;

    $secondsInAMonth = 30 * $secondsInADay;

    $secondsInAYear = 12 * $secondsInAMonth;

    $years = floor($inputSeconds / $secondsInAYear);

    $monthSeconds = $inputSeconds % $secondsInAYear;

    $months = floor($monthSeconds / $secondsInAMonth);

    $daySeconds = $monthSeconds % $secondsInAMonth;

    $days = floor($daySeconds / $secondsInADay);

    $hourSeconds = $daySeconds % $secondsInADay;

    $hours = floor($hourSeconds / $secondsInAnHour);

    $minuteSeconds = $hourSeconds % $secondsInAnHour;

    $minutes = floor($minuteSeconds / $secondsInAMinute);

    $remainingSeconds = $minuteSeconds % $secondsInAMinute;

    $seconds = ceil($remainingSeconds);

    $obj = array('hours'=>(int)$hours,'minutes'=>(int)$minutes);

    return $obj;}

//log_me();

	function sort_array_multidim(array $array, $order_by)

    {

        //TODO -c flexibility -o tufanbarisyildirim : this error can be deleted if you want to sort as sql like "NULL LAST/FIRST" behavior.

        if(!is_array($array[0]))

            throw new Exception('$array must be a multidimensional array!',E_USER_ERROR);

        $columns = explode(',',$order_by);

        foreach ($columns as $col_dir)

        {

            if(preg_match('/(.*)([\s]+)(ASC|DESC)/is',$col_dir,$matches))

            {

                if(!array_key_exists(trim($matches[1]),$array[0]))

                    trigger_error('Unknown Column <b>' . trim($matches[1]) . '</b>',E_USER_NOTICE);

                else

                {

                    if(isset($sorts[trim($matches[1])]))

                        trigger_error('Redundand specified column name : <b>' . trim($matches[1] . '</b>'));

                    $sorts[trim($matches[1])] = 'SORT_'.strtoupper(trim($matches[3]));

                }

            }

            else

            {

                throw new Exception("Incorrect syntax near : '{$col_dir}'",E_USER_ERROR);

            }

        }

        //TODO -c optimization -o tufanbarisyildirim : use array_* functions.

        $colarr = array();

        foreach ($sorts as $col => $order)

        {

            $colarr[$col] = array();

            foreach ($array as $k => $row)

            {

                $colarr[$col]['_'.$k] = strtolower($row[$col]);

            }

        }

        $multi_params = array();

        foreach ($sorts as $col => $order)

        {

            $multi_params[] = '$colarr[\'' . $col .'\']';

            $multi_params[] = $order;

        }

        $rum_params = implode(',',$multi_params);

        eval("array_multisort({$rum_params});");

        $sorted_array = array();

        foreach ($colarr as $col => $arr)

        {

            foreach ($arr as $k => $v)

            {

                $k = substr($k,1);

                if (!isset($sorted_array[$k]))

                    $sorted_array[$k] = $array[$k];

                $sorted_array[$k][$col] = $array[$k][$col];

            }

        }

        return array_values($sorted_array);

    }

	function convertinto24($time,$rad){ 

		if($time=='00:00' || $time=='00:00:00'){return '00:00:00';}else{return date("H:i", strtotime("".$time." ".$rad.""));}

	}

	function generatetripnumber($length = 6) {

		$characters = '123456789abcdef123456789ghijkmn123456789pqrstu123456789vwxyz';

		$charactersLength = strlen($characters);

		$randomString = '';

		for ($i = 0; $i < $length; $i++) {

			$randomString .= $characters[rand(0, $charactersLength - 1)];

		}

		return $randomString;

	}

	function check_drv()

	{

		$_SESSION['limit'] = 5;

		$_SESSION['adminlimit'] = 1;

		$db = new Database;	

		$db->connect();

		$Query = "SELECT fname FROM drivers WHERE drvstatus='Active'";

		if($db->query($Query) && $db->get_num_rows() > 0){	 $totalRows 	= 	$db->get_num_rows(); 

		if($totalRows>($_SESSION['limit']-1)){

			if($totalRows==$_SESSION['limit']){$_SESSION['update'] = '1'; }else{$_SESSION['update'] = '0';}

			/*echo '<script>alert("You have exceeded driver quota limit, please contact support @(480) 717-5032 ext: 2758");</script>';*/

			$_SESSION['driver_quota_message'] = 'Your subscription has exceeded the Driver quota limit on allocated tier. Please contact billing to enhance tier limit';

			$_SESSION['driver_quota'] = 'over';

            }else{$_SESSION['driver_quota_message'] = ''; $_SESSION['driver_quota'] = '';}	}else{$_SESSION['driver_quota_message'] = ''; $_SESSION['driver_quota'] = '';} 

		$logiticid = 0; $account = 'LogistiCare';

		$Queryhosp1 = "SELECT id FROM ".accounts."  WHERE TRIM(LOWER(REPLACE(account_name,' ','')))='".strtolower(trim(str_replace(' ','',$account)))."' ";

    if($db->query($Queryhosp1) && $db->get_num_rows() > 0){ $xyz = $db->fetch_one_assoc();  $logiticid = $xyz['id'];   }  

			 $_SESSION['logiticid'] = $logiticid;		

	$db->close();

	}	

check_drv();

?>