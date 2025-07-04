<?php
include '../db/connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM customer WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_customer.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: view_customer.php");
    exit();
}
?>