<?php
include "secure/database.php";
$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

$stmt = $mysqli->prepare("SELECT * FROM employee");
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows) {
  while ($row = $result->fetch_assoc()) {
    if (substr($row['password'], 0, 1) != '$') {
        echo $row['username'] . "<br>" . $row['password'];

        $username = $row['username'];
        $password = password_hash($row['password'], PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE employee SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $password, $username);
        if ($stmt->execute()) {
            echo "Updated password: " . $password;
        } else {
            echo "Failed to update password.";
        }
        echo "<hr>";
    }
  }
}