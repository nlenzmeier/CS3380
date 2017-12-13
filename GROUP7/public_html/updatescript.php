<?php
  include "secure/database.php";
  $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

  $statuses = array("active", "inactive");
  $ranks = array("junior", "senior");

  $stmt = $mysqli->prepare("SELECT username, position FROM employee");
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $username = $row['username'];
    $position = $row['position'];

    $randomStatus = $statuses[array_rand($statuses)];
    $randomRank = $ranks[array_rand($ranks)];

    if ($position == 1) {
      //Engineer
      $stmt = $mysqli->prepare("INSERT INTO engineer VALUES (?, ?, null, ?) ON DUPLICATE KEY UPDATE status = ?, rank = ?");
    } elseif ($position == 2) {
      //Conductor
      $stmt = $mysqli->prepare("INSERT INTO conductor VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status = ?, rank = ?");
    }
    if ($stmt->error) {
      echo $stmt->error;
    }
    $stmt->bind_param("sssss", $randomStatus, $randomRank, $username, $randomStatus, $randomRank);
    if ($stmt->execute()) {
      echo "$username has been updated.";
    } else {
      echo "Failed";
    }
  }
?>