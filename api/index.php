<?php

ob_start();
$ini = parse_ini_file(__DIR__ . "/api.ini", true, INI_SCANNER_TYPED);
const ROOT_PATH = __DIR__ . "/../";
require_once($ini["lib"]);
require_once(__DIR__ . "/root.php");
include_library("log", "time");

$root = new ROOT();

if($ini["auth"] && !$root->Auth()) {
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

function debugger(array $debug, ROOT &$root, array|object|string|null $res)
{
  $log = new LOG($root->path . "api/api.log", $debug["lineLimit"], "s", true, 4, $debug["messageLimit"]);
  if($debug["url"]) {
    $url = strtoupper($root->method) . " " . $root->host . "/" . $root->app . "/";
    foreach($root->arg as $arg) $url .= $arg . "/";
    $log->Record($url, "url");
  }
  if($debug["request"] && $root->props) $log->RecordUnknown($root->props, "req");
  if($debug["file"] && $root->files) $log->RecordUnknown($root->files, "file");
  if($debug["clear"] && ($clear = ob_get_clean())) $log->RecordUnknown($clear, "clr");
  if($debug["response"]) $log->RecordUnknown($res, "res");
}

api_index_end:
if($ini["debug"]["enable"]) debugger($ini["debug"], $root, $res);
else ob_get_clean();

ROOT::Exit($res);


