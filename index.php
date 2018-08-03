<?php require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
$dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
if (isset($_POST['btn'])) {
    $tag = strip_tags($_POST['tag']);
    foreach ($_FILES['myfile']['tmp_name'] as $key => $val) {
        $name = $_FILES['myfile']['name'][$key];
        $type = $_FILES['myfile']['type'][$key];
        $data = file_get_contents($_FILES['myfile']['tmp_name'][$key]);
        $stmt = $dbh->prepare('INSERT INTO myblob(name,mime,data,tag) VALUES(:name,:type,:data,:tag)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':tag', $tag);
        $stmt->execute();
    }
}
?>  
    
    <form method="post" enctype="multipart/form-data" >
    <input type="text" name="tag" id="tag">
        <input type="file" name="myfile[]" multiple="multiple">
        <button  name="btn">Upload</button>
    </form>
<p></p>
<ol>
<?php 
$stat = $dbh->prepare('SELECT * from myblob');
$stat->execute();
while ($row = $stat->fetch()) {
    echo '<li><a target="_blank" href="view.php?id=' . $row['id'] . '">' . $row['name'] . '</a><br>
    <embed src="data:' . $row['mime'] . ';base64,' . base64_encode($row['data']) . '" width="200"></li>';
}
?>

</ol>
</body>
</html>
