<?php

$url = strtolower($_SERVER['HTTP_HOST']);
$x = explode(":", $url, 2);

$host = $x[0];
if(count($x) == 2) {
  $port = (int)$x[1];
  $goto = match($port) {
    8080 => "api",
    80 => "web"
  };
}
else if(!preg_match('/^((25[0-5]|(2[0-4]|1\d|[1-9]|)\d)\.?\b){4}$/', $x[0], $matches)) {
  $x = explode(".", $host, 2);
  if(count($x) == 2) { $alias = $x[0]; $host = $x[1]; }
  else { $alias = NULL; $host = $x[0]; }
  $goto = match($alias) {
    "api" => "api",
    default => "web"
  };
}

$api = __DIR__ . "/api/";
$web = __DIR__ . "/web/lab/";

switch($goto) {
  case "api": require_once($api . "index.php"); break;
  case "web":
    if(file_exists($web . "index.html")) require_once($web . "index.html");
    else require_once($web . "index.php");
    break;
}