<?php

/** php.ini 
[Session]
session.cookie_samesite = "none"
session.cookie_secure = 0
session.cookie_httponly = 1
*/
session_set_cookie_params(["SameSite" => "none"]); #none,lax,strict
session_set_cookie_params(["Secure" => "false"]); #false,true
session_set_cookie_params(["HttpOnly" => "true"]); #false,true

// header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);