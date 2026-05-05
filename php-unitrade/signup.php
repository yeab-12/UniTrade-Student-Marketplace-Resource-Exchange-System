<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $ugr_id = $_POST['ugr_id'];
    $telegram = $_POST['telegram'];
    $phone = $_POST['phone'];
    $dept = $_POST['department'];
    $year = $_POST['year'];

    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        $user_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO profiles (user_id, full_name, ugr_id, astu_email, telegram_username, phone, department, year_of_study) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $ugr_id, $email, $telegram, $phone, $dept, $year]);

        $stmt = $pdo->prepare("INSERT INTO user_roles (user_id, role) VALUES (?, 'student')");
        $stmt->execute([$user_id]);

        $pdo->commit();
        header("Location: login.php?msg=Registration successful! Login now.");
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join UniTrade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-5 border-0 shadow-lg rounded-4">
                    <h2 class="fw-bold mb-4 text-center">Create account</h2>
                    <form action="signup.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="you@gmail.com" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">UGR ID</label>
                                <input type="text" name="ugr_id" class="form-control" placeholder="UGR/35614/16" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telegram Username</label>
                                <input type="text" name="telegram" class="form-control" placeholder="@username" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone (+251...)</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select name="department" class="form-select">
                                <option>Software Engineering</option>
                                <option>Electrical Engineering</option>
                                <option>Mechanical Engineering</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">Sign Up</button>
                    </form>
                    <p class="text-center mt-4 mb-0">Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
