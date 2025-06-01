<?php

$contactFile = ".contact.dat";

// ファイルをまるごと読み込む
// $fileContent = file_get_contents($contactFile);

// 上書き
// file_put_contents($contactFile, "上書きしました");

// 追記
// file_put_contents($contactFile, "\n追記しました", FILE_APPEND);

$allData = file($contactFile);

foreach ($allData as $line) {
  // 各行のデータを表示
  $lines = explode(",", $line);
  echo $lines[0] . "<br>";
  echo $lines[1] . "<br>";
  echo $lines[2] . "<br>";
  echo "<hr>";
}
