<?php

ob_start();
const ROOT_PATH = __DIR__ . "/../";
$ini = parse_ini_file(ROOT_PATH . "/cfg/server.ini", true, INI_SCANNER_TYPED);
require_once(ROOT_PATH . "/lib/php/__main.php");
require_once(__DIR__ . "/head.php");
require_once(__DIR__ . "/root.php");
include_library("log", "time");

$root = new ROOT();
$log = new LOG(__DIR__ . "/api.log", __DIR__ . "/log/", $ini["debug"]["lineLimit"]);

//------------------------------------------------------------------------------------------------- FNC

function api_debugger(array|object|string|null $resp = NULL)
{
  global $ini, $log, $root;
  $debug = $ini["debug"];
  if(!$debug["enable"]) { ob_get_clean(); return; }
  if($debug["url"]) {
    $url = strtoupper($root->method) . " " . $root->protocol . $root->host . "/" . $root->app . "/";
    foreach($root->arg as $arg) $url .= $arg . "/";
    $log->Push($url);
  }
  if($debug["request"] && $root->props) $log->Push("REQ", $root->props); 
  if($debug["files"] && $root->files) $log->Push("FILE", $root->files);
  if($debug["clear"] && ($clear = ob_get_clean())) $log->Push("CLR", LOG::File($clear));
  if($debug["response"]) $log->Push("RES", LOG::Var($resp));
  $log->Send("info");
}

function api_cors()
{
  global $ini, $log;
  if($ini["cors"] == "bypass") {
    $origin = isset($_SERVER["HTTP_ORIGIN"]) ? $_SERVER["HTTP_ORIGIN"] : "*";
    header("Access-Control-Allow-Origin: " . $origin);
  }
}

function api_response($resp) {
  api_debugger($resp);
  api_cors();
  ROOT::Exit($resp);
}

function api_auth()
{
  global $ini, $root;
  if($ini["auth"]["enable"] && !$root->Auth()) {
    api_response("Requires authorization");
  }
}

//------------------------------------------------------------------------------------------------- RUM

api_auth();

$include = ROOT_PATH . "app/" . $root->app . "/router.php";
if(file_exists($include)) {
  require_once($include);
  $router = new Router($root);
  api_response($router->Run());
}
else api_response("Service '$root->app' don't exist");
