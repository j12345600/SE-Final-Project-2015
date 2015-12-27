<?php
  include "config.php";
   //Connect to MySQL Server
   mysql_connect($dbhost, $dbuser, $dbpass);

   //Select Database
   mysql_select_db($dbname) or die(mysql_error());
   
   function redirect($url, $statusCode = 303)
	{
	   header('Location: ' . $url, true, $statusCode);
	   die();
	}
	$mode=$_GET['mode'];
	
?>
<html>
	<head>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	  <script type="text/javascript" src="/jquery/jquery.js" ></script>
      <script type="text/javascript" src="/jquery/jquery.cookie.js"></script>
      <script type="text/javascript" src="/jquery/functions.js"></script>
	  <script type="text/javascript" src="/jquery/jquery-ui.min.js"></script>
	   <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
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
			#interact{
				position: absolute;
				top:60px;
				font-size: 250%;
				
			}
	</style>
	</head>
   <body>

      <div id='ajaxDiv' >
		<a href="../bank" target="_self" style="text-decoration:none;color:blue;">主頁</a>
      	<?php
			   if (isset($_COOKIE["login"])){
			   	$cookie = json_decode( $_COOKIE[ "login" ] );
					echo "<h3 id=welcom>Welcome " . $cookie->data." </h3>";
					echo "<p id=timelf align='center'>Time left: ";
					include "cookieTime.php";
					echo " Sec(s)</p><div id=content>" ;
					echo'</div>';
					echo "<scripT>
		       if($.cookie('login')!=null)Clock.start();
	      	</script>";
				}
				else{
				redirect("../bank",303);
				}
				echo "<div id='interact' >";
				if($mode=='trans'){
				echo"<P> 選擇單筆或預約轉帳</p>
					<form>
					<table>
					<tr><td><input type='button' onclick='transfer(\"single\")' value='單筆'/></td></tr>
					<tr><td><input type='button' onclick='transfer(\"rsvd\")' value='預約'/></td></tr>
					</table>
					</form></div>";
				}
				else if($mode=='check'){
					
				}
				else if($mode=='debt'){
					
				}
				else redirect("../bank",303);
				
				?>
		
      </div>
   </body>
</html>