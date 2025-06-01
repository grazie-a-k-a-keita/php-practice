<?php

require "db_connection.php";

// $sql = "select * from contacts";
// $stmt = $pdo->query($sql); // ステートメント
// $result = $stmt->fetchAll();

// echo "<pre>";
// var_dump($result);
// echo "</pre>";

$sql = "select * from contacts where id = :id";

$pdo->beginTransaction();

try {
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue("id", 1, PDO::PARAM_INT);
  $stmt->execute();

  $pdo->commit();
} catch (PDOException $e) {
  $pdo->rollBack();
}
