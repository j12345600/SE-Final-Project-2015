<?php
   $dbhost = "localhost";
   $dbuser = "root";
   $dbpass = "root";
   $dbname = "dbname";
   //Connect to MySQL Server
   mysql_connect($dbhost, $dbuser, $dbpass);

   //Select Database
   mysql_select_db($dbname) or die(mysql_error());
   
   if (isset($_COOKIE["login"])){
   	$cookie = json_decode( $_COOKIE[ "login" ] );
	echo "Welcome " . $cookie->data . "!<br />";
	readfile("form.html");
	}
	 else{
	 echo "Please sign in!<br />";
	readfile("login form.html");}
?>