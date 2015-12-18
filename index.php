<?php
  include "config.php";
   //Connect to MySQL Server
   mysql_connect($dbhost, $dbuser, $dbpass);

   //Select Database
   mysql_select_db($dbname) or die(mysql_error());
?>
<html>
	<head>
			<script type="text/javascript" src="/jquery/jquery.js" ></script>
      <script type="text/javascript" src="/jquery/jquery.cookie.js"></script>
      <script type="text/javascript" src="/jquery/functions.js"></script>
      <style>
			#welcom {
					  float: left;
			}
			#timelf {
						position: absolute;
						right:10px;
    			  width:150px;
					  height:19px; 
					  margin: auto;
					  border: 1px solid #FF8C8C; 
					  color:#800000;
			}
			#content {
						position: absolute;
						font-size: 250%;
						top:200px;
					  margin: auto;
					  right:50%;
					  color:#800000;
			}
			.fbutton{
					width:200%;
				}
	</style>
	</head>
   <body>

      <div id='ajaxDiv' >
      	<?php
			   if (isset($_COOKIE["login"])){
			   	$cookie = json_decode( $_COOKIE[ "login" ] );
					echo "<h3 id=welcom>Welcome " . $cookie->data." </h3>";
					echo "<p id=timelf align='center'>Time left: ";
					include "cookieTime.php";
					echo " Sec(s)</p><div id=content>" ;
					readfile("form.html");
					echo'</div>';
					echo "<script>
		       if($.cookie('login')!=null)Clock.start();
	      	</script>";
				}
				else{
				 echo "Please sign in!<br />";
				 readfile("loginform.html");}
				?>

      </div>
   </body>
</html>


