<?php
  session_start();

  if (!isset($_SESSION['user'])) {
    header("Location: index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reserve Now!</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
        
        $(function getMeetText() {

            //function getMeetText() {
                var text = "Meet Our Team!";
                console.dir(text);
                document.getElementById("meet").innerHTML = text;
            
            
        });
    
    </script>
    
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
      
      .background2 {
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            padding: 112px;
            background-image: url(photos/nicolle.jpg);
            background-attachment: fixed;
            border: 1px solid black;
            background-size: 100% 100%;
      }
      
      .background3 {
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            padding: 112px;
            background-image: url(photos/darrell.jpg);
            background-attachment: fixed;
            border: 1px solid black;
            background-size: 100% 100%;
      }

      .background3 {
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            padding: 112px;
            background-image: url(photos/aaron.jpg);
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
      
      .aboutLog {
            width: 100%;
            border: 2px solid white;
            border-radius: 25px;
            padding: 20px;
            background: rgba(210, 180, 140, .5);
      }
      
      .aboutDiv {
            width: 45%;
            height: 200px;
            border: 2px solid white;
            text-align: center;
            border-radius: 25px;
            padding: 20px;
            display: inline-block;
            background: rgba(210, 180, 140, .8);
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
        <li><a href="reserve.php">Reserve Cars</a></li>
          <li class="active"><a href="about.php">About</a></li>  
      </ul>
    </div>
  </div>
</nav>
    
<div class="container-fluid text-center">    
  <div class="row content">
<!--
    <div class="col-sm-2 sidenav">
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
    </div>
-->
   <div class="col-sm-8 text-left"> 
       <h1 id="meet" onload="getMeetText()"></h1>
      <hr> 

    <div class="aboutLog"> 
        <div class="aboutDiv">
            <h3>Nicolle Lenzmeier</h3>
            <img src="photos/nicolle.JPG" alt="thumbUp" height="100" width="100" style="transform: rotate(90deg);"> 
            <p>Team Leader</p>
        </div>
      
        <div class="aboutDiv">
            <h3>Darrell Martin</h3>
            <img src="photos/darrell.JPG" alt="peace" height="100" width="100" style="transform: rotate(90deg);"> 
            <p>Developer / Designer</p>
        </div>
      
        <div class="aboutDiv">
            <h3>Aaron Thomas</h3>
            <img src="photos/aaron.JPG" alt="thumbsUp" height="100" width="100" style="transform: rotate(90deg);"> 
            <p>Savior / Genius</p>
        </div>
      
        <div class="aboutDiv">
            <h3>Jacob Krawjewski</h3>
            <img src="photos/noImage.jpg" alt="thumbsUp" height="100" width="100">
            <p>Intern</p>
        </div>
      
        <div class="aboutDiv">
            <h3>Murphy Ward</h3>
            <img src="photos/noImage.jpg" alt="thumbsUp" height="100" width="100">
            <p>Intern</p>
        </div>
      
        <div class="aboutDiv">
            <h3>Ryan Cobb</h3>
            <img src="photos/noImage.jpg" alt="thumbsUp" height="100" width="100">
            <p>Intern</p>
        </div>
      </div>
   </div>
  </div>
</div>
</body>
</html>
