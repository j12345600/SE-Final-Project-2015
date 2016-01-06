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
		   $query ="insert into history_record(accountNUM,Inwardremittance,Outwardremittance, balance) 					   		   values($from,0,$amount,$fbalance)";
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
			   $query ="insert into history_record(accountNUM,Inwardremittance,Outwardremittance, balance) 							   values($to,$amount,0,$tbalance)";
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
   else if($mode=='chkStatus'){
	   $query= "SELECT * FROM account_list WHERE accountNum = '$bankAct'";
	   $qry_result=mysql_query($query) or die(mysql_error());
	   $row = mysql_fetch_array($qry_result);
	   if($row) {
		   $debt=$row['debt'];
	   }
	   else {echo "cann't find account $bankAct";exit();}
	   echo $debt;
   }
   else if($mode=='pay'){
	   $query= "SELECT * FROM account_list WHERE accountNum = '$bankAct'";
	   $qry_result=mysql_query($query) or die(mysql_error());
	   $row = mysql_fetch_array($qry_result);
	   echo "<p>還款結果</p>";
	   if($row) {
		   $debt=$row['debt'];
		   $balance=$row['balance'];
	   }
	   else {echo "cann't find account $bankAct";exit();}
	   if($balance>=$debt){
		   $left=$balance-$debt;
		   $query="UPDATE account_list SET balance='$left' WHERE accountNum='$bankAct'";
		   mysql_query($query) or die(mysql_error());
		   $query="UPDATE account_list SET debt='0' WHERE accountNum='$bankAct'";
		   mysql_query($query) or die(mysql_error());
		   $query ="insert into history_record(accountNUM,Inwardremittance,Outwardremittance, balance) 					   		   values($bankAct,0,$debt,$left)";
		   mysql_query($query) or die(mysql_error());
		   echo "
		 <table>
		<tr><td>還款成功</td></tr>
		<tr><td><button type=\"reset\" onclick=\"location.href='../bank'\">返回選單</button></td></tr>
		</table>";
	   }
	   else {
		 
	   }
   }
   else if($mode=='balance'){
	   $query= "SELECT * FROM account_list WHERE accountNum = '$bankAct'";
	   $qry_result=mysql_query($query) or die(mysql_error());
	   $row = mysql_fetch_array($qry_result);
	   if($row) {
		   $balance=$row['balance'];
	   }
	   else {echo "cann't find account $bankAct";exit();}
	   echo $balance;
   }
  
   else if($mode=='log'){
   		 $dater=$_POST['date'];
   		$date=DateTime::createFromFormat('Y/m/d H:i:s', $dater.'23:59:59');
   		$mysql_date_string=$date->format('Y-m-d H:i:s');
	   $query= "SELECT * FROM history_record WHERE accountNUM = '$bankAct' AND date<='$mysql_date_string' ";
	   $qry_result=mysql_query($query) or die(mysql_error());
 	   while($row = mysql_fetch_array($qry_result)) {
			
	 		echo "
			 <tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>";
	   }
    }
?>