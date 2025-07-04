<?php
include '../db/connection.php';

// Fetch districts for dropdown
$districts = [];
$district_query = "SELECT * FROM district";
$result = $conn->query($district_query);
if ($result) {
    $districts = $result->fetch_all(MYSQLI_ASSOC);
}

// Insert logic
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $district_id = $_POST['district']; // this is ID

    $sql = "INSERT INTO customer (title, first_name, last_name, contact_no, district)
            VALUES ('$title', '$first_name', '$last_name', '$contact_no', '$district_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Customer added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Add Customer</h2>
    <form method="POST">
        <div class="form-group">
            <label>Title</label>
            <select name="title" class="form-control" required>
                <option value="">Select Title</option>
                <option>Mr</option>
                <option>Mrs</option>
                <option>Miss</option>
                <option>Dr</option>
            </select>
        </div>

        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Contact Number</label>
            <input type="tel" name="contact_no" class="form-control" required pattern="[0-9]{10}">
        </div>

        <div class="form-group">
            <label>District</label>
            <select name="district" class="form-control" required>
                <option value="">Select District</option>
                <?php foreach ($districts as $d) { ?>
                    <option value="<?php echo $d['id']; ?>"><?php echo $d['district']; ?></option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Customer</button>
    </form>
</body>
</html>