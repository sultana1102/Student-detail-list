<?php
include('dbConnect.php');
$id = $_GET['id'];

$sql = "SELECT student.student_name, student.student_email, student.student_address,
         student.student_image, student.created_at, classes.class_name AS class_name 
        FROM student 
        LEFT JOIN classes ON student.class_id = classes.class_id 
        WHERE student.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Student</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center my-1">View Student Details</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> <?= htmlspecialchars($student['student_name']); ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($student['student_email']); ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($student['student_address']); ?></p>
                        <p><strong>Class:</strong> <?= htmlspecialchars($student['class_name']); ?></p>
                        <p><strong>Creation Date:</strong> <?= htmlspecialchars($student['created_at']); ?></p>
                        <p>
                            <?php if (!empty($student['student_image'])): ?>
                                <img src="<?= $student['student_image']; ?>" alt="Student Image" width="150" class="img-thumbnail">
                            <?php else: ?>
                                <span class="text-muted">No Image Available</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-center mt-3">
        <a href="index.php" class="btn btn-warning">Back to Home</a>
    </div>
    </div>
    </div>
</body>

</html>