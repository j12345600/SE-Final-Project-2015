<?php
 	 $cookie = json_decode( $_COOKIE[ "login" ] );
   $expiry = $cookie->expiry;
   echo ($expiry-time());
?>