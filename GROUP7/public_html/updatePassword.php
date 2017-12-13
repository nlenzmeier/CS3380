<form method="post">
  Old Password: <input type="password" name="oldPass" /><br />
  New Password: <input type="password" name="newPass1" /><br />
  Type New Password Again: <input type="password" name="newPass2" /><br />
  <input type="submit" name="submit" value="Update Password" />
</form>
<?php
  session_start();
  include "secure/database.php";

  $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

  if (!isset($_SESSION['user'])) {
    header("Location: index.php");
  }

  if (isset($_POST['submit'])) {
    $oldPassHash = password_hash(htmlspecialchars($_POST['oldPass']), PASSWORD_DEFAULT);

    if (!password_verify($_POST['oldPass'], $_SESSION['user']['password'])) {
      echo "Old password does not match.";
      return;
    }

    if (empty($_POST['oldPass']) || empty($_POST['newPass1']) || empty($_POST['newPass2'])) {
      echo "All password fields are required.";
      return;
    }

    if ($_POST['newPass1'] != $_POST['newPass2']) {
      echo "New passwords do not match.";
      return;
    }

    $username = $_SESSION['user']['username'];
    $newPass = password_hash(htmlspecialchars($_POST['newPass1']), PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("UPDATE employee SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $newPass, $username);
    if ($stmt->execute()) {
      $_SESSION['user']['password'] = $newPass;
      echo "Password has been updated.";
      return;
    } else {
      echo "Error updating password.";
      return;
    }
  }
?>