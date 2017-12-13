<?php
session_start();
include "secure/database.php";
$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
if ($mysqli->connect_errno) { //Terminate script if there is a connection error
	   echo "Failed to connect to MySQLI on Line 30";
	   exit(); 
}
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$user_ip = getUserIP();
$username = $_SESSION['user']['username'];
//echo "". $username . " is this test";
  
//  unset($_SESSION['user']);

//if(unset($_SESSION['user'])){
if($_SESSION['user']['username']){
    $sql = "INSERT INTO website_Login VALUES(?, now(), ?, 'logout')";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $user_ip, $username);
    $stmt->execute(); 
}
if($_SESSION['user']['company_id']){
    $custid = $_SESSION['user']['company_id'];
    $sql = "INSERT INTO website_Login VALUES(?, now(), ?, 'logout')";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $user_ip, $custid);
    $stmt->execute();
}
//}
unset($_SESSION['user']);
  header("Location: index.php");
?>