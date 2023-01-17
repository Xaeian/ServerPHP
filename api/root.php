<?php

//--------------------------------------------------------------------------------------------------------------------- FNC

function normalize_upload_files(array $files)
{
  $out = [];
  foreach ($files as $i => $file) {
    if (!is_array($file["name"])) {
      $out[$i] = $file;
      continue;
    }
    foreach ($file["name"] as $j => $name) {
      $out[$j] = [
        "name" => $name,
        "type" => $file["type"][$j],
        "tmp_name" => $file["tmp_name"][$j],
        "error" => $file["error"][$j],
        "size" => $file["size"][$j]
      ];
    }
  }
  return $out;
}

function route_name($req)
{
  $req = preg_replace("/[^a-z0-9]+/", " ", strtolower($req));
  $req = explode_noempty(" ", $req);
  $name = "";
  foreach($req as $str) $name .= ucfirst($str);
  return $name;
}

//--------------------------------------------------------------------------------------------------------------------- ROOT

class ROOT
{
  public string $path;
  public array $arg;
  public string $app;
  public string $method;
  public string $host;
  public array $files = [];
  public object|array|null $props = null;
  public ?object $auth = null;

  function __construct()
  {
    $this->path = path_pretty(ROOT_PATH, false);
    $this->arg = explode("/", trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "\/"));
    $this->app = array_shift($this->arg);
    $this->method = strtolower($_SERVER["REQUEST_METHOD"]);
    $this->host = strtolower($_SERVER['HTTP_HOST']);
    $type = (isset($_SERVER["CONTENT_TYPE"]) ? strtolower($_SERVER["CONTENT_TYPE"]) : "");
    $this->files = normalize_upload_files($_FILES);
    if($type == "application/json" || $type == "text/plain") // JSON Applications
      $this->props = json_decode(file_get_contents('php://input'));
    else if(preg_match("/^multipart\/form-data/", $type) && $this->method == "post" && isset($_POST)) // FORM Applications
      $this->props = (object)$_POST;
    else if(count($_GET)) { // GET Applications
      $this->props = new \stdClass();
      foreach($_GET as $key => $value) {
        $this->props->$key = json_decode($value);
      }
    }
  }

  public function Auth(): bool
  {
    session_start();
    if(isset($_SESSION) && isset($_SESSION["auth"]) && $_SESSION['auth']->ip == $_SERVER['REMOTE_ADDR']) {
      $this->auth = $_SESSION["auth"];
      $_SESSION["auth"] = clone $this->auth;
      $_SESSION["time"] = gmdate("Y-m-d H:i:s");
      return true;
    }
    unset($_SESSION["auth"]);
    if($this->app == "auth") return true;   
    return false;
  }

  static function Exit($response)
  {
    if(is_string($response)) exit($response);
    if($response === NULL) exit();
    exit(json_encode($response));
  }
}

//--------------------------------------------------------------------------------------------------------------------- End
