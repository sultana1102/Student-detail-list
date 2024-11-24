<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class=" col-lg-6 col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center my-1">Class List</h2>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-hover text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>SL. No.</th>
                                    <th>Class Name</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include("dbConnect.php");

                                $sql = "SELECT * FROM classes";

                                $rslist = mysqli_query($conn, $sql);
                                $cnt = 0; // Initialize the counter

                                while ($row = mysqli_fetch_array($rslist)) {
                                    $cnt++;
                                    echo "<tr>";
                                    echo "<td>" . $cnt . "</td>";
                                    echo "<td>" . htmlspecialchars($row["class_name"]) . "</td>";
                                    echo "<td>
                                <a href='delete_class.php?c_id={$row["class_id"]}' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                                    echo "<td>
                                <a href='edit_class.php?c_id={$row["class_id"]}' class='btn btn-success btn-sm'>Edit</a>
                              </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="text-center row">
                            <a href="index.php" class="btn btn-warning col-lg-5 mx-4">Home Page</a>
                            <a href="add_class.php" class="btn btn-info col-lg-5 mx-4">Add More Classes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>