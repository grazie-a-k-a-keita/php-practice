<?php

function insertContacts($request)
{
  require "db_connection.php";

  $params = [
    "id" => null,
    "name" => $request["name"],
    "email" => $request["email"],
    "url" => $request["url"],
    "gender" => $request["gender"],
    "age" => $request["age"],
    "contact" => $request["contact"],
    "created_at" => null
  ];

  // $params = [
  //   "id" => null,
  //   "name" => "氏名",
  //   "email" => "test@example.com",
  //   "url" => "https://exmaple.com",
  //   "gender" => "1",
  //   "age" => "1",
  //   "contact" => "内容",
  //   "created_at" => null
  // ];

  $count = 0;
  $columns = "";
  $values = "";

  foreach (array_keys($params) as $key) {
    if ($count++ > 0) {
      $columns .= ",";
      $values .= ",";
    }
    $columns .= $key;
    $values .= ":" . $key;
  }

  $sql = "insert into contacts (" . $columns . ") values (" . $values . ")";

  var_dump($sql);

  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
}
