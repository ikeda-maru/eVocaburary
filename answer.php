<?php require_once('data.php') ?>

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
      <p><?php echo $question ?></p>
      <p><?php echo $_POST['answer'] ?></p>
      <form action="questioning.php" method="post">
        <input type="submit" value="次の問題" class="btn">
      </form>
    </article>
  </main>
</body>
</html>