<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // In a real app we'd save to contact_messages table
    echo "<script>alert('Message sent! We will get back to you soon.'); window.location.href='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | UniTrade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-5">
                <h1 class="fw-bold mb-4">Get in touch</h1>
                <p class="text-muted mb-5">Questions, feedback or trouble with a listing? We're here to help.</p>
                <div class="mb-4">
                    <h6 class="fw-bold">Email</h6>
                    <p class="text-primary">yeabsiragetachew613@gmail.com</p>
                </div>
                <div class="mb-4">
                    <h6 class="fw-bold">Telegram support</h6>
                    <p class="text-primary">t.me/unitrade_support</p>
                </div>
                <div>
                    <h6 class="fw-bold">Location</h6>
                    <p class="text-muted">Adama Science and Technology University<br>Adama, Ethiopia</p>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card p-5 border-0 shadow-sm rounded-4">
                    <h4 class="fw-bold mb-4">Send us a message</h4>
                    <form action="contact.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold">Send message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
