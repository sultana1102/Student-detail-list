<?php
$id = $_REQUEST["c_id"];
include("dbConnect.php");

$query = "DELETE FROM classes WHERE class_id = $id";
mysqli_query($conn, $query);

header("location:classes.php");
