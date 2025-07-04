<?php
include '../db/connection.php';

$sql = "SELECT 
            customer.id, customer.title, customer.first_name, customer.last_name, 
            customer.contact_no, district.district 
        FROM customer
        JOIN district ON customer.district = district.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Customers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2>Customer List</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact Number</th>
                <th>District</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact_no']); ?></td>
                        <td><?php echo htmlspecialchars($row['district']); ?></td>
                        <td>
                            <a href="edit_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
            <?php } } else { ?>
                <tr><td colspan="6">No customers found.</td></tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>