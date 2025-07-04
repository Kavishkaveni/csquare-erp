<?php
include '../db/connection.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    header("Location: view_customer.php");
    exit();
}

$id = intval($_GET['id']);

// Initialize variables
$title = $first_name = $last_name = $contact_no = $district = "";
$error = "";

// If form submitted, update the customer
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $district = $conn->real_escape_string($_POST['district']);

    // Simple validation (you can add more)
    if (empty($first_name) || empty($last_name) || empty($contact_no) || empty($district)) {
        $error = "Please fill all required fields.";
    } else {
        $sql = "UPDATE customer SET 
                title='$title', 
                first_name='$first_name', 
                last_name='$last_name', 
                contact_no='$contact_no', 
                district='$district' 
                WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            header("Location: view_customer.php?msg=updated");
            exit();
        } else {
            $error = "Error updating record: " . $conn->error;
        }
    }
} else {
    // Load customer data to pre-fill form
    $result = $conn->query("SELECT * FROM customer WHERE id=$id");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $contact_no = $row['contact_no'];
        $district = $row['district'];
    } else {
        header("Location: view_customer.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2>Edit Customer</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Title</label>
            <select name="title" class="form-control" required>
                <option value="">Select Title</option>
                <option value="Mr" <?php if ($title == "Mr") echo "selected"; ?>>Mr</option>
                <option value="Mrs" <?php if ($title == "Mrs") echo "selected"; ?>>Mrs</option>
                <option value="Miss" <?php if ($title == "Miss") echo "selected"; ?>>Miss</option>
                <option value="Dr" <?php if ($title == "Dr") echo "selected"; ?>>Dr</option>
            </select>
        </div>

        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Contact Number</label>
            <input type="tel" name="contact_no" value="<?php echo htmlspecialchars($contact_no); ?>" class="form-control" required pattern="[0-9]{10}">
        </div>

        <div class="form-group">
            <label>District</label>
            <input type="text" name="district" value="<?php echo htmlspecialchars($district); ?>" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Customer</button>
        <a href="view_customer.php" class="btn btn-secondary">Cancel</a>
    </form>

</body>
</html>