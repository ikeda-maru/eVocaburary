<?php
// Clickjacking対策
header('X-FRAME-OPTIONS:DENT');
session_start();

$dsn      = 'mysql:dbname=eVocaburary;host=localhost;charset=utf8mb4';
$user     = 'root';
$password = 'root';

try {
  $pdo = new PDO ($dsn, $user, $password);

  $sql_select = 'SELECT * FROM vocaburaries';

  $stmt_select = $pdo->query($sql_select);

  $vocaburaries = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  exit($e->getMessage());
}

// 登録した単語を配列として変数に代入
foreach ($vocaburaries as $vocaburary) {
  $meaning[] = $vocaburary['meaning'];
}

// n番目の単語を変数に代入
$question = $meaning[array_rand($meaning)];
?>

