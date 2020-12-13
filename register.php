<?php
//ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['user']) != "") {
  header("Location: bbs.php");
}

include_once 'db_connect.php';

if (!empty($_POST['username'])) {
  $username2 = $_POST['username'];
  $email = $_POST['email'];
  $password2 = $_POST['password'];
  $password2 = password_hash($password2, PASSWORD_DEFAULT);
}

if (!empty($username2) && !empty($email) && !empty($password2)) {
  $sql = "insert into users (username,email,password) values (:username,:email,:password)";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':username', $username2, PDO::PARAM_STR);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->bindParam(':password', $password2, PDO::PARAM_STR);

  if ($rs = $stmt->execute()) {
    echo "<div class=\"alert alert-success\" role=\"alert\">登録しました</div>";
  } else {
    echo "<div class=\"alert alert-danger\" role=\"alert\">エラーが発生しました。</div>";
  }
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>会員登録フォーム</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
    <a href="#" class="navbar-brand">KEIJIBAN</a>
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">ログイン</a>
    </div>
  </nav>

  <div class="w-75 m-auto pt-5">
    <h1 class="text-center pt-2">会員登録フォーム</h1>
    <form method="post">
      <div class="form-group">
        <input type="text" class="form-control" name="username" placeholder="ユーザー名" required />
      </div>
      <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="メールアドレス" required />
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="パスワード" required />
      </div>
      <button type="submit" class="btn btn-primary" name="login">会員登録する</button>
    </form>
  </div>
</body>

</html>