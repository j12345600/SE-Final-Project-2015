<?php
   include "config.php";   
   //Connect to MySQL Server
   mysql_connect($dbhost, $dbuser, $dbpass);

   //Select Database
   mysql_select_db($dbname) or die(mysql_error());
   
   $account = $_POST['account'];
   $password = $_POST['password'];
   $account = mysql_real_escape_string($account);
   $password = mysql_real_escape_string($password);
   
   $query = "SELECT * FROM account_list WHERE account COLLATE latin1_general_cs
   = '$account' AND password COLLATE latin1_general_cs = '$password' ";
   //Execute query
   $qry_result = mysql_query($query) or die(mysql_error());
   $row = mysql_fetch_array($qry_result);
   if($row){
   	$expiry = time() + 300;
		$data = $row['name'];
		$cookieData = (object) array( "data" => $data, "expiry" => $expiry);
   		setcookie("login", json_encode( $cookieData ), $expiry);
   		echo "<h3 id=welcom>Welcome " . $data ." </h3>";
   		echo "<p id=timelf align='center'>Time left:".( $expiry-time())." Sec(s)</p><div id=content>" ;
   		readfile("form.html");
   	  echo'</div>';
   	} 
   else {echo "Login in fail!";
 		readfile("loginform.html");}
?>