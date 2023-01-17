<?php

session_set_cookie_params(["SameSite" => "none"]); #none,lax,strict
session_set_cookie_params(["Secure" => "false"]); #false,true
session_set_cookie_params(["HttpOnly" => "true"]); #false,true