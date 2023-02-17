<?php

ob_start();
const ROOT_PATH = __DIR__ . "/../";
$ini = parse_ini_file(ROOT_PATH . "/cfg/server.ini", true, INI_SCANNER_TYPED);
require_once(ROOT_PATH . "/lib/php/__main.php");
require_once(__DIR__ . "/head.php");
require_once(__DIR__ . "/root.php");
include_library("log", "time");

$root = new ROOT();

if($ini["auth"]["enable"] && !$root->Auth()) {
  $res = "Requires authorization";
  goto api_index_end;
}

$include = ROOT_PATH . "app/" . $root->app . "/router.php";
$res = "";
if(file_exists($include)) {
  require_once($include);
  $router = new Router($root);
  $res = $router->Run();
}

function debugger(array $debug, ROOT &$root, array|object|string|null $resp)
{
  $log = new LOG(__DIR__ . "/api.log", __DIR__ . "/log/", $debug["lineLimit"]);
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

api_index_end:
if($ini["debug"]["enable"]) debugger($ini["debug"], $root, $res);
else ob_get_clean();

if($ini["cors"] == "bypass") {
  $origin = isset($_SERVER["HTTP_ORIGIN"]) ? $_SERVER["HTTP_ORIGIN"] : "*";
  header("Access-Control-Allow-Origin: " . $origin);
}

ROOT::Exit($res);
