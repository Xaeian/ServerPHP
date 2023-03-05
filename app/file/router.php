<?php

class Router
{
  private string $goto;
  private string $url = "";
  private string $ext;
  private null|array|object $props;

  public function __construct(ROOT $root)
  {
    $ini = __DIR__ . "/redirect.ini";
    if(file_exists($ini)) $redirect = parse_ini_file($ini, true, INI_SCANNER_TYPED);
    else $redirect = NULL;
    if(count($root->arg) <= 1) return;
    $fileset = array_shift($root->arg);
    if($redirect && in_array($fileset, array_keys($redirect))) $dir = $redirect[$fileset];
    else $dir = __DIR__ . "/$fileset";
    $this->url = $dir . "/" . implode("/", $root->arg);
    $this->ext = pathinfo($this->url, PATHINFO_EXTENSION);
    if(strtolower($root->method) == "get") $this->goto = "File";
  }

  public function Run(): mixed
  {
    if(!$this->url) return "You need to pass dataset as the first argument";
    if(method_exists($this, $this->goto)) return $this->{$this->goto}();
    return "File service doesn't support '$this->goto' request";
  }

  private function ReplyFile($url)
  {
    api_debugger();
    api_cors();
    $fp = fopen($url, 'rb');
    header("Content-Type: " . match($this->ext) {
      "jpg", "jpeg"  => "image/jpg",
      "png" => "image/png",
      "pdf" => "application/pdf",
      "csv" => "text/csv"
    });
    header("Content-Length: " . filesize($url));
    fpassthru($fp);
    exit();
  }

  # GET {{host}}/file/{url}
  function File()
  {
    if(file_exists($this->url)) $this->ReplyFile($this->url);
    $nfound = __DIR__ . "/#/nfound." . $this->ext;
    if(file_exists($nfound)) $this->ReplyFile($nfound);
    $readme = __DIR__ . "/readme.md";
    $this->ReplyFile($readme);
  }
}
