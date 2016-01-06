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
					  font-size:250%;
					  color:#009FCC;
			}
			#timelf {
						position: absolute;
						right:10px;
						width:300px;
					  height:30px; 
					  margin: auto;
					  border: 1px solid #FF8C8C; 
					  color:#800000;
					  font-size:25px;
			}
			#content {
						position: absolute;
						font-size: 250%;
						top:200px;
					  margin: auto;
					  right:50%;
					  color:#800000;
			}
			#myForm{
				position:relative;
				margin-left:43%;
				margin-top:13%;
			}
			.button {
				-moz-box-shadow:inset 0px 1px 0px 0px #5891c9;
				-webkit-box-shadow:inset 0px 1px 0px 0px #5891c9;
				box-shadow:inset 0px 1px 0px 0px #5891c9;
				background-color:#007dc1;
				-moz-border-radius:3px;
				-webkit-border-radius:3px;
				border-radius:3px;
				border:1px solid #124d77;
				display:inline-block;
				cursor:pointer;
				color:#ffffff;
				font-family:Arial;
				font-size:13px;
				padding:6px 24px;
				text-decoration:none;
				text-shadow:0px 1px 0px #154682;
			}
			.button:hover {
				background-color:#0061a7;
			}
			#logout {
				position:absolute;
				left:10px;
				height:30px;
				top:100px;
			}

			.fbutton {
				position:relative;
				left:50%;
				margin-top:10px;
				margin-bottom:10px;
				width:300px;
				 -moz-box-shadow:inset 0px 0px 7px 0px #dcecfb;
				 -webkit-box-shadow:inset 0px 0px 7px 0px #dcecfb;
				 box-shadow:inset 0px 0px 7px 0px #dcecfb;
				 background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #bddbfa), color-stop(1, #80b5ea));
				 background:-moz-linear-gradient(top, #bddbfa 5%, #80b5ea 100%);
				 background:-webkit-linear-gradient(top, #bddbfa 5%, #80b5ea 100%);
				 background:-o-linear-gradient(top, #bddbfa 5%, #80b5ea 100%);
				 background:-ms-linear-gradient(top, #bddbfa 5%, #80b5ea 100%);
				 background:linear-gradient(to bottom, #bddbfa 5%, #80b5ea 100%);
				 filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#bddbfa', endColorstr='#80b5ea',GradientType=0);
				 background-color:#bddbfa;
				 -moz-border-radius:3px;
				 -webkit-border-radius:3px;
				 border-radius:3px;
				 display:inline-block;
				 cursor:pointer;
				 color:#ffffff;
				 font-size:20px;
				 padding:5px 50px;
				 text-decoration:none;
				 text-shadow:3px 3px 2px #528ecc;
			}
			.fbutton:hover {
				 background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #80b5ea), color-stop(1, #bddbfa));
				 background:-moz-linear-gradient(top, #80b5ea 5%, #bddbfa 100%);
				 background:-webkit-linear-gradient(top, #80b5ea 5%, #bddbfa 100%);
				 background:-o-linear-gradient(top, #80b5ea 5%, #bddbfa 100%);
				 background:-ms-linear-gradient(top, #80b5ea 5%, #bddbfa 100%);
				 background:linear-gradient(to bottom, #80b5ea 5%, #bddbfa 100%);
				 filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#80b5ea', endColorstr='#bddbfa',GradientType=0);
				 background-color:#80b5ea;
			}
			body {
				background-image: url("bank.png");
				background-repeat: no-repeat;
				background-position: center top;
				background-size:10%;
			}
			
	</style>
	
	</head>
   <body bgcolor='#ffe4e1'>

      <div id='ajaxDiv' >
	 
      	<?php
			   if (isset($_COOKIE["login"])){
			   	$cookie = json_decode( $_COOKIE[ "login" ] );
				echo "<input type='button' onclick='logout()' value='登出' class='button' id='logout'/>";
					echo "<h1 id=welcom>Welcome " . $cookie->data." </h3>";
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
				 echo "<h1>Please sign in!</h1><br />";
				 readfile("loginform.html");}
				?>

			<script type="text/javascript">
			$('body').on('keypress', 'input', function(args) {
				if (args.keyCode == 13) {
					login();
					return false;
				}
			});
	</script>
      </div>
   </body>
</html>


