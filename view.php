<?php
require 'config.php';
$dbh = new PDO('mysql:host=$servername;dbname=$dbname', '$username', '$password');
$id = isset($_GET['id']) ? $_GET['id'] : '';
$stat = $dbh->prepare('SELECT * from myblob where id=:id');
$stat->bindParam(':id', $id);
$stat->execute();
$row = $stat->fetch();
header('Content-Type:' . $row['mime']);
echo $row['data'];
