<?php
// Initialize variables
$showPopup = false;
$name = $email = $message = "";
$errors = [];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Simple validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If no errors, show the popup
    if (empty($errors)) {
        $showPopup = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Popup on Form Submission</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }
        .form-container h2 {
            margin-top: 0;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border 0.2s;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 90px;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #0056b3;
        }
        .errors {
            background: #ffe0e0;
            color: #b00020;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            list-style: none;
        }
        .errors li {
            margin: 4px 0;
        }

        /* Modal / Popup Styles */
        .modal-overlay {
            display: <?php echo $showPopup ? 'flex' : 'none'; ?>;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }
        .modal-box {
            background: #fff;
            padding: 35px 40px;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: slideUp 0.3s ease;
        }
        .modal-box h3 {
            margin-top: 0;
            color: #28a745;
            font-size: 24px;
        }
        .modal-box p {
            color: #555;
            line-height: 1.6;
            margin: 10px 0 20px;
        }
        .modal-box .details {
            text-align: left;
            background: #f8f9fa;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .modal-box .details strong {
            color: #333;
        }
        .btn-close {
            padding: 10px 30px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-close:hover {
            background: #0056b3;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>

    <!-- Form -->
    <div class="form-container">
        <h2>Enter Your Details</h2>

        <?php if (!empty($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="John Doe"
                       value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="john@example.com"
                       value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Write something..."
                          required><?php echo htmlspecialchars($message); ?></textarea>
            </div>
            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>

    <!-- Popup Modal -->
    <div class="modal-overlay" id="popupModal">
        <div class="modal-box">
            <h3>✅ Success!</h3>
            <p>Your details have been received. Here's what you submitted:</p>
            <div class="details">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Message:</strong> <?php echo htmlspecialchars($message); ?></p>
            </div>
            <button class="btn-close" onclick="closePopup()">Close</button>
        </div>
    </div>

    <script>
        function closePopup() {
            document.getElementById('popupModal').style.display = 'none';
        }

        // Optional: Close popup when clicking outside the modal box
        document.getElementById('popupModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePopup();
            }
        });

        // Optional: Close popup with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePopup();
            }
        });
    </script>

</body>
</html>