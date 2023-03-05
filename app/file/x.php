<?php



$redirect = parse_ini_file(__DIR__ . "/redirects.ini", true, INI_SCANNER_TYPED);

var_dump($redirect);