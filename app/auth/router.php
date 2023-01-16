<?php

class Router
{
  public object|null $auth;
  public string $file;
  public array $users;
  public int $nextID;

  private const CREATE_AUTH =
  <<< SQL
  CREATE TABLE auth
  (
    id INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    user CHAR(64) NOT NULL,
    password CHAR(128) NOT NULL UNIQUE,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id)
  )
  SQL;

  private const NOT_PERMISSIONS = "You are not permissions to perform this operation";

  function __construct(ROOT $root)
  {
    $this->arg = $root->arg;
    $this->service = strtolower($root->method) . route_name(array_shift($this->arg));
    $this->props = $root->props;
    $this->auth = $root->auth;
    // if(storage IS csv)
    $this->file = __DIR__ . "/users.csv";
    $this->users = csv_load($this->file);
    $this->nextID = 1;
    foreach($this->users as $i => $user) {
      foreach($user as $j => $value) {
        $this->users[$i][$j] = match($value) {
          "True" => true,
          "False" => false,
          default => $value
        };
      }
      $id = (int)$user["id"];
      if($id >= $this->nextID) $this->nextID = $id + 1;
    }
  }

  public function Run(): object|string
  {
    if(method_exists($this, $this->service)) {
      return $this->{$this->service}();
    }
    return "Auth service doesn't support this request";
  }

  function Build()
  {
    // if(storage IS mysql OR postgres OR sqlite)
    // $this->conn->createDatabase($this->conn->db);
    // $this->conn->dropTable($this->table);
    // $this->conn->Run(self::CREATE_AUTH);
  }

  static function Retrun($message, $status = false): object
  {
    return (object)["status" => $status, "message" => $message];
  }

  static function PasswordEncryption(string $password)
  {
    return md5(htmlentities($password, ENT_QUOTES));
  }

  private function AreYouAdmin(): bool
  {
    if($this->auth && $this->auth->level == 0) return true;
    else return false;
  }

  private function ThatYou(string $user): bool
  {
    if($this->auth && $this->auth->user == $user) return true;
    else return false;
  }

  private function UserValidation(string $user): null|string
  {
    if(!$user) return "No Username";
    echo $user;
    if(preg_match("/[^0-9A-Za-z_\-]+/", $user)) return "Username can contain only uppercase and lowercase letters, numbers and special chars '_', '-'";
    return null;
  }

  private function EmailValidation(string $email): null|string
  {
    if(!$email) return "No email address";
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Invalid 'email' format";
    return null;
  }

  private function PasswordValidation(string $password): null|string
  {
    if(!$password) return "No password";
    if(strlen($password) <= '8') return "Password have to contain at least 8 characters";
    if(!preg_match("/[0-9]+/", $password)) return "Password have to contain at least 1 number";
    if(!preg_match("/[A-Z]+/", $password)) return "Password have to contain at least 1 capital letter";
    if(!preg_match("/[a-z]+/", $password)) return "Password have to contain at least 1 lowercase letter";
    $specialChars = preg_replace("/[0-9A-Za-z]+/", "", $password);
    if($specialChars === "") return "Password have to contain at least 1 special char";
    return null;
  }

  function postCreate(): object
  {
    if(!$this->AreYouAdmin()) return $this->Retrun(self::NOT_PERMISSIONS);
    if($missing = required_fields($this->props, ["user", "email", "password"])) {
      return $this->Retrun("Field {$missing} are missing");
    }
    if($error = $this->UserValidation($this->props->user)) return $this->Retrun($error);
    if($error = $this->EmailValidation($this->props->email)) return $this->Retrun($error);
    if($error = $this->PasswordValidation($this->props->password)) return $this->Retrun($error);
    foreach($this->users as $user) {
      if($user["name"] == $this->props->user) return $this->Retrun("User {$this->props->user} exists");
      if(($user["email"] == $this->props->email)) return $this->Retrun("Email address {$this->props->email} is used");
    }
    if(!property_exists($this->props, 'level')) $this->props->level = 2;
    $new = [
      "id" => $this->nextID,
      "name" => $this->props->user,
      "email" => strtolower($this->props->email),
      "password" => self::PasswordEncryption($this->props->password),
      "active" => true,
      "level" => $this->props->level,
      "created_at" => gmdate("Y-m-d H:i:s"),
      "last_activity" => NULL
    ];
    array_push($this->users, $new);
    csv_save($this->file, $this->users);
    return $this->Retrun("User {$this->props->user} has been created"); 
  }

  function postUpdate(): object
  {
    if(!property_exists($this->props, 'user')) $this->props->user = $this->auth->user;
    if(!($this->AreYouAdmin() || $this->ThatYou($this->auth->user))) return $this->Retrun(self::NOT_PERMISSIONS);
    if($error = $this->UserValidation($this->props->user)) return $this->Retrun($error);
    if($error = $this->EmailValidation($this->props->email)) return $this->Retrun($error);
    if($error = $this->PasswordValidation($this->props->password)) return $this->Retrun($error);
    // TODO: Update
    csv_save($this->file, $this->users);
    return $this->Retrun("User {$this->props->user} has been updated"); 
  }

  function postLogin(): object
  {
    if($missing = required_fields($this->props, ["user", "password"])) {
      unset($_SESSION["auth"]);
      return $this->Retrun("Field {$missing} are missing");
    }
    $name = strtolower($this->props->user);
    $passwd = $this->props->password;
    $passwd = self::PasswordEncryption($passwd);
    foreach($this->users as $i => $user) {
      if($user["active"] && (strtolower($user["name"]) == $name || $user["email"] == $name) && $user["password"] == $passwd) {
        $_SESSION["auth"] = new stdClass();
        $_SESSION["auth"]->id = $user["id"];
        $_SESSION["auth"]->name = $user["name"];
        $_SESSION["auth"]->email = $user["email"];
        $_SESSION["auth"]->level = (int)$user["level"];
        $_SESSION["auth"]->ip = $_SERVER['REMOTE_ADDR'];
        $_SESSION["time"] = gmdate("Y-m-d H:i:s");
        $this->users[$i]["last_activity"] = $_SESSION["time"];
        csv_save($this->file, $this->users);
        $return = $this->Retrun("Login was successful", true);
        $return->user = ["name" => $user["name"], "email" => $user["email"], "level" => $user["level"]];
        return $return;
      }
    }
    unset($_SESSION["auth"]);
    return $this->Retrun("The user doesn't exist or the password isn't correct");
  }

  function postLogout(): object
  {
    if(isset($_SESSION) && isset($_SESSION["auth"]) && $_SESSION['auth']->ip == $_SERVER['REMOTE_ADDR']) {
      unset($_SESSION["auth"]);
      return $this->Retrun("Logout was successful", true);
    }
    return $this->Retrun("You're not logged in");
  }
}