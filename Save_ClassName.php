<?php
$class_name = $_REQUEST["className"];

include("dbConnect.php");

$sql = "insert into classes(class_name) values('$class_name')";
mysqli_query($conn, $sql) or die("Query error");

if ($sql) {
    header("location:classes.php?resmsg=1");
    exit();
} else {
    header("location:classes.php?resmsg=2");
    exit();
}
