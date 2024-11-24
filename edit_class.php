<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
</head>

<body>
    <?php
    $id = $_REQUEST["c_id"];
    include("dbConnect.php");

    $query = "SELECT * FROM classes WHERE class_id = $id";
    $rs = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($rs);
    ?>

    <form method="post" action="update_class.php">
        <input type="hidden" name="c_id" value="<?php echo $id; ?>">

        <label>Enter Class Name</label>
        <input type="text" name="className" id="className" value="<?php echo $row['class_name']; ?>"><br><br>

        <button type="submit">Edit</button>
    </form>
</body>

</html>