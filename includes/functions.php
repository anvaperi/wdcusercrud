<?php
  function createToken() {
    $salt = random_bytes(15); 
    return sha1(mt_rand(1,1000000) . $salt); 
  }
  
  function checkToken($formToken, $sessionToken = false) {
    if($sessionToken === false){$sessionToken = $_SESSION['token'];}
    return ( isset($formToken) 
      && !empty($formToken) 
      && isset($sessionToken) 
      && $formToken === $sessionToken
    );	
  }
?>