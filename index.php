<?php

//ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['user']) != "") {
  header("Location: bbs.php");
}
include_once 'db_connect.php';

if (!empty($_POST['email'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
}

if (!empty($email) && !empty($password)) {
  $sql = "select * from users where email=(:email)";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  if (!$rs = $stmt->execute()) {
    die("not query:" . $rs->errorInfo());
  }
  while ($row = $stmt->fetch()) {
    $db_hashed_pwd = $row['password'];
    $user_id = $row['user_id'];
  }

  if (password_verify($password, $db_hashed_pwd)) {
    $_SESSION['user'] = $user_id;
    header("Location: bbs.php");
    exit;
  } else {
    echo "<div class=\"alert alert-danger\" role=\"alert\">メールアドレスとパスワードが一致しません。</div>";
  }
}


?>

<!DOCTYPE HTML>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ログインフォーム</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
    <a href="#" class="navbar-brand">KEIJIBAN</a>
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="register.php">会員登録</a>
    </div>
  </nav>

  <div class="w-75 m-auto pt-5">
    <h1 class="text-center pt-2">ログインフォーム</h1>
    <form method="post">
      <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="メールアドレス" required />
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="パスワード" required />
      </div>
      <button type="submit" class="btn btn-primary" name="login">ログインする</button>
    </form>
  </div>
</body>

</html>