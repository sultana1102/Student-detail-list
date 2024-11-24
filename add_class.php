<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Classes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class=" col-lg-6 col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center my-1">Add New Class</h2>
                    </div>
                    <div class="card-body">

                        <form method="post" action="Save_ClassName.php">

                            <?php
                            if (isset($_REQUEST["resmsg"])) {
                                echo ("<div class='alert alert-info text-center'>");
                                if ($_REQUEST["resmsg"] == 1) {
                                    echo ("Your data has been saved.");
                                } else if ($_REQUEST["resmsg"] == 2) {
                                    echo ("Form should be filled.");
                                }
                                echo ("</div>");
                            }
                            ?>

                            <div class="mb-3">
                                <label for="className" class="form-label fs-4">Enter Class Name</label>
                                <input type="text" class="form-control" name="className" id="className" required>
                            </div>

                            <div class="text-center">
                                <a href="classes.php" class="btn btn-warning col-lg-5 my-3 mx-4">Back To List</a>
                                <button type="submit" class="btn btn-success col-lg-5 mx-4">Submit</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>