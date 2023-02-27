<?php

class Router
{
  private string $goto;
  private string $url;
  private string $ext;
  private null|array|object $props;

  public function __construct(ROOT $root)
  {
    $this->url = path_pretty(__DIR__ . "/" . implode("/", $root->arg));
    $this->ext = pathinfo($this->url, PATHINFO_EXTENSION);
    if(strtolower($root->method) == "get") $this->goto = "File";
  }

  public function Run(): array|object|string|null
  {
    if(method_exists($this, $this->goto)) {
      return $this->{$this->goto}();
    }
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
    $notfound = __DIR__ . "/#/not-found." . $this->ext;
    if(file_exists($notfound)) $this->ReplyFile($notfound);
    $readme = __DIR__ . "/readme.md";
    $this->ReplyFile($readme);
  }
}
