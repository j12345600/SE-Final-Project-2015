<?php
   $cookie = json_decode( $_COOKIE[ "login" ] );
   
   $data=$cookie->data;
   $expiry = time() + 300;
   $bankAccount=$cookie->bankAct;
   $cookieData = (object) array( "data" => $data, "expiry" => $expiry,"bankAct"=>$bankAccount);
   setcookie("login", json_encode( $cookieData ), $expiry);

   echo ($expiry-time());
?>