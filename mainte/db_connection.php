<?php

const DB_HOST = "mysql:dbname=udemy_php;host=db;charset=utf8";
const DB_USER = "php_user";
const DB_PASSWORD = "password123";


try {
  $pdo = new PDO(DB_HOST, DB_USER, DB_PASSWORD, [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
  ]);

  echo "接続成功";
} catch (PDOException $e) {
  echo "接続に失敗しました" . $e->getMessage() . "\n";
}
