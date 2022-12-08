<?php

require_once($_SERVER["PHPPATH"]);
$ini = file_load(__DIR__ . "/php.ini");
$lines = explode_enter($ini);

$str = "";
foreach($lines as $line) {
  if($line == "" || (($line[0] == ";" || $line[0] == "#") && (!isset($line[1]) || $line[1] == " ")));
  else {
    $str .= $line . PHP_EOL;
  }
  file_save(__DIR__ . "/php-new.ini", $str);
}

?>