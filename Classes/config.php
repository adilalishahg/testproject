<?php
	/* *************************** *
	   * This is configuration file.
	   * It contains db access parameters, Imge paths, globally used array.	
	   *  
	   *************************** */
	   
	   //include_once('database_tables.php');
	   //include_once('site_functions.php');
	   //include_once('../Classes/imgUploader.php');

	//include ("ez/write_logs.php");
	$rootPath =$_SERVER['DOCUMENT_ROOT'] ."/";

	error_reporting(E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set("display_errors","on");

	$adminPrefix			= "../";					//admin prefix.
	
		//FOR TEST SERVER KEYSTONE
		
		/*$dbname 	= "localhost";				//host name.
		$dbuser 	= "valleyme_HTTuser";	  	    //database user.
		$dbpasswd 	= "HTT123!!!";				//database passwd.
		$dbs		= "valleyme_HTTnew";*/		//database name.
		#$siteURL	= "";

		#$dbname 	= "HTT_db2.db.4546065.hostedresource.com";				//host name.
		#$dbuser 	= "HTT_db2";	  	    //database user.
		#$dbpasswd 	= "HTT123456";				//database passwd.
		#$dbs		= "HTT_db2";		//database name.
		#$siteURL	= "";
		
		//FOR LOCAL SERVER
		
		
		$dbname 	= "httglobal.db.3694931.hostedresource.com";				//host name.
		$dbuser 	= "httglobal";					//database user.
		$dbpasswd 	= "Hybrid123!";						//database passwd.
		$dbs		= "httglobal";				//database name.
		
		
define("TBL_ADMIN","admin");
define("TBL_CONTACT","contact_info");
define("TBL_CONTENTS","contents");
define("TBL_COUNTRIES","countries");
define("TBL_HOSPITALS","hospitals");
define("TBL_TESTIMONIALS","testimonials");
define("TBL_COPY_RIGHTS","copy_rights"); 
define("TBL_REQUESTS","requests");
define("TBL_FORMS","request_info");
define("TBL_REOCCURENCE","recurring");
define("TBL_VEHTYPES","vehtype");
define("TBL_SEO","seo");
define("TBL_STATES","states");
define("TBL_CM","casemanagers");
define("TBL_DRIVERS","drivers");
?>
