<?php 
session_start();

require "conn/vraag.php";
$vraag = new Vraag();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Question Form</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>