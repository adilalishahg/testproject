<?php
function mysql2userformat($mysql_date){
	
	$date_exp = explode("-",$mysql_date);
	$date_arr = $date_exp[2] . "/" . $date_exp[1] . "/" . $date_exp[0] ; 
	return $date_arr;
}

function user2mysqlformat($user_date){
	
	$date_exp = explode("/",$user_date);
	$mysql_date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0] ; 
	return $mysql_date;
}


?>