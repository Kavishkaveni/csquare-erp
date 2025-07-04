<?php
include '../db/connection.php';

$startDate = '';
$endDate = '';
$records = [];

if (isset($_POST['filter'])) {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $sql = "SELECT i.invoice_no, i.date, c.first_name AS customer_name, c.district, 
                   i.item_count, i.amount AS invoice_amount
            FROM invoice i
            LEFT JOIN customer c ON i.customer = c.id
            WHERE DATE(i.date) BETWEEN ? AND ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $records = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Invoice Report</h2>

    <form method="POST" class="form-inline mb-3">
        <label class="mr-2">Start Date:</label>
        <input type="date" name="start_date" class="form-control mr-2" value="<?= $startDate ?>" required>

        <label class="mr-2">End Date:</label>
        <input type="date" name="end_date" class="form-control mr-2" value="<?= $endDate ?>" required>

        <button type="submit" name="filter" class="btn btn-primary">Filter</button>
    </form>

    <?php if (!empty($records)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>District</th>
                    <th>Item Count</th>
                    <th>Invoice Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $row): ?>
                    <tr>
                        <td><?= $row['invoice_no'] ?></td>
                        <td><?= $row['date'] ?></td>
                        <td><?= $row['customer_name'] ?></td>
                        <td><?= $row['district'] ?></td>
                        <td><?= $row['item_count'] ?></td>
                        <td><?= $row['invoice_amount'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($_POST['filter'])): ?>
        <p>No records found for the selected date range.</p>
    <?php endif; ?>
</body>
</html>