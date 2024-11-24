<?php
include('dbConnect.php');

// Fetch students with class names
$sql = "SELECT student.id, student.student_name, student.student_email, student.created_at, student.student_image,
 classes.class_name AS class_name 
        FROM student
        LEFT JOIN classes ON student.class_id = classes.class_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./style.css" rel="styelsheet">
</head>

<body>
    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center my-1">Student List</h2>
            </div>
            <div class="card-body my-3">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Creation Date</th>
                            <th>Class</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="text-center">
                                <td>
                                    <?php if (!empty($row['student_image'])): ?>
                                        <img src="<?= $row['student_image']; ?>" alt="Thumbnail" width="50" class="img-thumbnail">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['student_name']); ?></td>
                                <td><?= htmlspecialchars($row['student_email']); ?></td>
                                <td><?= htmlspecialchars($row['created_at']); ?></td>
                                <td><?= htmlspecialchars($row['class_name']); ?></td>
                                <td>
                                    <a href="view.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">View</a>
                                    <a href="edit_student_info.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="delete_student.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="my-3 d-flex justify-content-between">
                    <a href="classes.php" class="btn btn-primary text-white">See Class List</a>
                    <a href="create_student_form.php" class="btn btn-primary">Add New Student</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>