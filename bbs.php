<?php
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
//ini_set('display_errors', 1);

session_start();
include_once 'db_connect.php';
if (!isset($_SESSION['user'])) {
  header("Location: index.php");
}

if (!empty($_POST['message'])) {
  $message = $_POST['message'];
  $user_id = $_SESSION['user'];
}

if (!empty($message)) {
  $sql = "insert into message (message,post_date,user_id) values (:message,NOW(),:user_id)";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':message', $message, PDO::PARAM_STR);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
  if (!$rs = $stmt->execute()) {
    die("not query:" . $rs->errorInfo());
  }
}

$sql = "select * from message join users on message.user_id=users.user_id order by post_id desc";
if (!$rs = $db->query($sql)) {
  die("not query:" . $rs->errorInfo());
}
$out = "<ul class=\"list-group\">";
while ($row = $rs->fetch()) {
  $out .= sprintf(
    "<li class=\"list-group-item\"><span class=\"font-weight-bold\">%s </span><span class=\"font-weight-light\">%s </span><br>    %s </li>",
    $row['username'],
    $row['post_date'],
    $row['message']
  );
}
$out .= "</ul>";

$db = null;

?>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <title>掲示板</title>
</head>

<body class="w-75 m-auto">
  <h1 class="text-center">掲示板</h1>
  <a href="logout.php?logout">ログアウト</a>
  <form method="post">
    <div class="form-group">
      <label for="text">Textarea:</label>
      <textarea name="message" class="form-control"></textarea>
    </div>
    <input class="btn btn-primary" type="submit" value="OK">
  </form>
  <?= $out ?>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>