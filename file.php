<?php
// Check if the form was submitted
$name  = "";
$email = "";
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Grab and clean the input
    $name  = htmlspecialchars(trim($_POST["name"]  ?? ""));
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $submitted = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Prompt Demo</title>
</head>
<body>

<h2>Enter Your Details</h2>

<form method="POST" action="">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit">Submit</button>
</form>

<?php if ($submitted): ?>
    <!-- This JavaScript runs after PHP processes the form -->
    <script>
        alert("Hello <?php echo $name; ?>!\nYour email is: <?php echo $email; ?>");
    </script>
<?php endif; ?>

</body>
</html>