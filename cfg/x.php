<?php

require_once($_SERVER["PHPPATH"]);

$ini = parse_ini_file(__DIR__ . "/server.ini", true, INI_SCANNER_TYPED);

var_dump($ini);