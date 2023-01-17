<?php

class Router
{
  private string $service;
  private string $url;
  private string $ext;
  private null|array|object $props;

  public function __construct(ROOT $root)
  {
    $this->url = path_pretty(__DIR__ . "/" . implode("/", $root->arg));
    $this->ext = pathinfo($this->url, PATHINFO_EXTENSION);
    if(strtolower($root->method) == "get") $this->service = "File";
  }

  public function Run(): array|object|string|null
  {
    if(method_exists($this, $this->service)) {
      return $this->{$this->service}();
    }
    return "File service doesn't support this request";
  }

  private function ReplyFile($url)
  { 
    $fp = fopen($url, 'rb');
    header("Content-Type: " . match($this->ext) {
      "jpg", "jpeg"  => "image/jpg",
      "png" => "image/png"
    });
    header("Content-Length: " . filesize($url));
    fpassthru($fp);
    exit();
  }

  # GET {{host}}/file/{url}
  function File()
  {
    if(file_exists($this->url)) $this->ReplyFile($this->url);
    $notfound = __DIR__ . "/not-found." . $this->ext;
    if(file_exists($notfound)) $this->ReplyFile($notfound);
    $readme = __DIR__ . "/readme.md";
    $this->ReplyFile($readme);
  }
}
