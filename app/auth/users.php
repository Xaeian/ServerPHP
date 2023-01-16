<?php

class Users
{
  public string $file;
  public array $users;
  public array $names;
  public array $emails;

  function __construct()
  {
    $this->file = __DIR__ . "/users.csv";
    $this->users = csv_load($this->file);
    $this->names = [];
    $this->emails = [];
    foreach($this->users as $i => $user) {
      $id = (int)$user["id"];
      $this->names[$id] = $user["name"];
      $this->emails[$id] = $user["email"];
    }
  }

  function Name(?int $id): ?string
  {
    if($id && isset($this->names[$id])) return $this->names[$id];
    return NULL;
  }

  function Email(?int $id): ?string
  {
    if($id && isset($this->emails[$id])) return $this->emails[$id];
    return NULL;
  }
}