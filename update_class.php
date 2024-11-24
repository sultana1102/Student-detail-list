<?php

// Fetch data from the form
$class_name = $_REQUEST["className"];
$id = $_REQUEST["c_id"];

include("dbConnect.php");


$sql = "UPDATE classes SET class_name = '$class_name'
          WHERE class_id = $id";
if (mysqli_query($conn, $sql)) {
    header("Location: classes.php?resmsg=1");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    header("Location: classes.php?resmsg=2");
    exit();
}
