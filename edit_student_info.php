<?php
include("dbConnect.php");

// Fetch the student ID from the URL
if (isset($_GET['id'])) {
    $student_id = intval($_GET['id']);
    
    // Fetch the student data
    $student_query = "SELECT * FROM student WHERE id = $student_id";
    $student_result = mysqli_query($conn, $student_query);
    $student = mysqli_fetch_assoc($student_result);
    
    if (!$student) {
        echo "Student not found.";
        exit;
    }

    // Fetch classes for the dropdown
    $classes_query = "SELECT * FROM classes";
    $classes_result = mysqli_query($conn, $classes_query);
} else {
    echo "No student ID provided.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $class_id = intval($_POST['class_id']);
    $image_path = $student['student_image']; // Keep the existing image by default

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_error = $_FILES['image']['error'];

        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if ($image_error === 0 && $image_size > 0 && in_array($file_extension, $allowed_extensions)) {
            // Upload the image
            $new_image_name = uniqid("img_", true) . '.' . $file_extension;
            $image_upload_path = "uploads/" . $new_image_name;
            move_uploaded_file($image_tmp_name, $image_upload_path);

            // Update image path
            $image_path = $image_upload_path;

            // Optionally, delete the old image
            if (file_exists($student['student_image'])) {
                unlink($student['student_image']);
            }
        } else {
            echo "Invalid image format. Only JPG, JPEG, and PNG are allowed.";
            exit;
        }
    }

    // Validate the name field
    if (empty($name)) {
        echo "Name is required.";
        exit;
    }

    // Update the student record
    $update_query = "UPDATE student SET 
                        student_name = '$name', 
                        student_email = '$email', 
                        student_address = '$address', 
                        class_id = $class_id, 
                        student_image = '$image_path' 
                     WHERE id = $student_id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: index.php?message=Student updated successfully");
        exit;
    } else {
        echo "Error updating student: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
        <div class=" col-lg-6 col-md-6">
            <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center my-1">Edit Student</h2>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" 
                               value="<?php echo htmlspecialchars($student['student_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" 
                               value="<?php echo htmlspecialchars($student['student_email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <textarea name="address" id="address" class="form-control" required><?php echo htmlspecialchars($student['student_address']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class:</label>
                        <select name="class_id" id="class_id" class="form-select" required>
                            <?php
                            while ($class = mysqli_fetch_assoc($classes_result)) {
                                $selected = $class['class_id'] == $student['class_id'] ? 'selected' : '';
                                echo "<option value='{$class['class_id']}' $selected>{$class['class_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" name="image" id="image" class="form-control" accept=".jpg, .jpeg, .png">
                        <?php if ($student['student_image']): ?>
                            <div class="mt-2">
                                <img src="<?php echo $student['student_image']; ?>" alt="Student Image" class="img-thumbnail" width="150">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="text-center my-4 row">
                        <button type="submit" class="btn btn-success col-lg-5 mx-4">Update Student</button>
                        <a href="index.php" class="btn btn-warning col-lg-5 mx-4">Back to Home</a>
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>
