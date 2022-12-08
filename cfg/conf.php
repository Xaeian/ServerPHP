<?php

require_once($_SERVER["PHPPATH"]);
$arg = arg_load($argv, ["-p" => "--path"]);

$paths = parse_ini_file(__DIR__ . "/conf.ini", true, INI_SCANNER_TYPED);

$os = strtolower(PHP_OS_FAMILY);
if($os = "windows")
  $os = PHP_WINDOWS_VERSION_PRODUCTTYPE == 3 ? "windows" : "xampp";
$filedir = $arg->path ? $paths[$arg->path] : $paths[$os];

foreach($paths[$os] as $file => $dir) {
  if(!$dir) continue;
  $path = path_pretty($dir . "/" . $file);
  $conf = path_pretty(__DIR__ . "/conf/" . $os . "/" . $file);
  disp($conf, "»", $path);
  file_delete($path);
  copy($conf, $path);
}