<?php
$id = $_REQUEST["id"];
include("dbConnect.php");

$query = "DELETE FROM student WHERE id = $id";
mysqli_query($conn, $query);

header("location:index.php");
