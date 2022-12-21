<?php
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

// Clickjacking対策
header('X-FRAME-OPTIONS:DENT');
// CSRF対策
session_start();

// 登録した単語を配列として変数に代入
foreach ($vocaburaries as $vocaburary) {
  $meaning[] = $vocaburary['meaning'];
}
// n番目の単語を変数に代入
$question = $meaning[array_rand($meaning)];

$pageFlg = 0;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>eVocaburary</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header>
    <nav>
      <a href="index.php">eVocaburary</a>
    </nav>
  </header>
  <main>
    <article class="questioning">
      <h1>問題</h1>
      <?php if ($pageFlg === 0) : ?>
        <p><?php echo $question; ?></p>
        <form action="answer.php" method="post">
          <input type="text" name="answer">
          <input type="submit" value="答え" class="btn">
        </form>
      <?php elseif ($pageFlg === 1) : ?>
        <p><?php echo $question; ?></p>
        <p><?php $_POST['answer'] ?></p>
    </article>
  </main>
</body>
</html>