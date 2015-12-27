<?php
   include 'config.php'; 
   function transfer($BankCode,$from,$to,$amount){
	   $query = "SELECT * FROM account_list WHERE accountNum = '$from'";
	   $qry_result=mysql_query($query) or die(mysql_error());
	   $row = mysql_fetch_array($qry_result);
	   if($row) {
		   $fbalance=$row['balance'];
		   $fbalance-=$amount;
		   $query="UPDATE account_list SET balance='$fbalance' WHERE accountNum='$from'";
		   mysql_query($query) or die(mysql_error());
	   }
	   else {echo "cann't find account $from";exit();}
	   if($BankCode=='000'){
		   $query = "SELECT * FROM account_list WHERE accountNum = '$to'";
		   $qry_result=mysql_query($query) or die(mysql_error());
		   
		   $row = mysql_fetch_array($qry_result);
		   if($row) {
			   $tbalance=$row['balance'];
			   $tbalance+=$amount;
			   $query="UPDATE account_list SET balance='$tbalance' WHERE accountNum='$to'";
			   mysql_query($query) or die(mysql_error());
			   }
			else {echo "cann't find account $to";exit();}
	   }
    }
   //Connect to MySQL Server
   mysql_connect($dbhost, $dbuser, $dbpass);

   //Select Database
   mysql_select_db($dbname) or die(mysql_error());

   // Retrieve data from Query String
   $mode = $_POST['mode'];
   
   $cookie = json_decode( $_COOKIE[ "login" ] );
   $expiry = $cookie->expiry;
   $bankAct = $cookie->bankAct;
   //$mysqltime = date ("Y-m-d H:i:s", $phptime);

   if($mode=='rsvd'||$mode=='single'){
	   $BankCode=$_POST['BC'];
	   $BankAccount=$_POST['BAC'];
	   $amount=$_POST['amount'];
	   if(is_numeric($BankCode)&&is_numeric($BankAccount)&&is_numeric($amount)){
		   if($mode=='single') transfer($BankCode,$bankAct,$BankAccount,$amount);
	   }
	   else{
		   echo "input error";
		   exit();
	   }
	   
   }
   
?>