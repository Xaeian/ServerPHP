<?php

require_once($_SERVER["PHPPATH"]);

$ini = parse_ini_file(__DIR__ . "/server.ini", true, INI_SCANNER_TYPED);

foreach($ini["conf"] as $file => $dir) {
  if(!$dir) continue;
  $path = path_pretty($dir . "/" . $file);
  $conf = path_pretty(__DIR__ . "/conf/" . $file);
  disp($conf, "»", $path);
  file_delete($path);
  copy($conf, $path);
}