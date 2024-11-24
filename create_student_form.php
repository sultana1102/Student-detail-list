<?php
include('dbConnect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    if (empty($name)) {
        die("Name is required.");
    }

    // Directory for uploads
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        die("Upload directory does not exist. Please create it.");
    }

    // Validate image format
    $allowed = ['jpg', 'jpeg', 'png'];
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed)) {
        die("Invalid image format.");
    }
    if ($image['size'] > 2 * 1024 * 1024) { // 2MB limit
        die("Image size exceeds 2MB limit.");
    }

    // Generate Unique Filename
    $unique_name = uniqid("img_", true) . '.' . $ext;
    $image_path = $upload_dir . $unique_name;

    if (!move_uploaded_file($image['tmp_name'], $image_path)) {
        die("Failed to upload image. Please try again.");
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO student (student_name, student_email, student_address, class_id, student_image, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param('sssds', $name, $email, $address, $class_id, $image_path);
    $stmt->execute();

    header("Location: index.php");
    exit();
}

// Fetch classes for dropdown
$classes = $conn->query("SELECT * FROM classes");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class=" col-lg-6 col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center my-1">Create New Student</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
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
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" class="form-control" required><br>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class:</label>
                                <select name="class_id" class="form-select">
                                    <option value="" selected>Select Class</option>
                                    <?php while ($class = $classes->fetch_assoc()): ?>
                                        <option value="<?= $class['class_id']; ?>"><?= $class['class_name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image:</label>
                                <input type="file" name="image" accept=".jpg, .jpeg, .png" class="form-control" required>
                            </div>

                            <div class="text-center row mx-1">
                                <a href="index.php" class="btn btn-warning col-lg-4 my-3 mx-4">Home Page</a>
                                <button type="submit" class="btn btn-success my-3 mx-4 col-lg-6">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>