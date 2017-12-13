<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reserve Now!</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */

      .background {
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            padding: 112px;
            background-image: url(photos/danish_train_desktop.png);
            background-attachment: fixed;
            border: 1px solid black;
            background-size: 100% 100%;
      }

    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }

    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}

    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }

    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }

      .orderLog {
            border: 2px solid white;
            border-radius: 25px;
            padding: 20px;
            background: rgba(210, 180, 140, .5);
      }



  </style>
</head>
<body class="background">
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="logout.php">Off the Rails!</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="shop.php">Home</a></li>
        <li class="active"><a href="#">Reserve Cars</a></li>
        <li><a href="about.php">About</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php

include "secure/database.php";
$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

if (isset($_POST['doReserve'])) {
  $stmt = $mysqli->prepare("SELECT * FROM equipment WHERE serial_number = ?");
  $stmt->bind_param("i", $_POST['reserve']);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows) {
    $row = $result->fetch_assoc();

    echo "<div>
      <form method='POST'>
        <input type='hidden' name='accept' />
        <input type='hidden' name='reserve' value='{$_POST['reserve']}'>
        Company ID: <input type='text' name='company_id'><br>
        Type of Cargo: <input type='text' name='cargo' readonly='readonly' value='{$row['type']}'><br>
        Price: <input type='text' name='price' readonly='readonly' value='{$row['price']}'><br>
        <input class='btn btn-primary' type='submit' value='Approve Sale'>
      </form>
    </div>";
  }
}


if (isset($_POST['accept'])) {
  $stmt = $mysqli->prepare("UPDATE equipment SET reservation_status = '1' WHERE serial_number = ?");
  $stmt->bind_param("s", $_POST['reserve']);
  $stmt->execute();

  $stmt = $mysqli->prepare("INSERT INTO orders (serial_number, company_ID) VALUES (?, ?)");
  $reserveID = $_POST['reserve'];
  $companyID = $_POST['company_id'];
  $stmt->bind_param("ss", $reserveID, $companyID);

  if ($stmt->execute()) {
    echo "Car was reserved";
  } else {
    echo "Error reserving car: " . $stmt->error;
  }
}

if (!isset($_POST['doReserve']) && !isset($_POST['accept'])) {
  header('Location: reserve.php');
}
?>
</body>
</html>

