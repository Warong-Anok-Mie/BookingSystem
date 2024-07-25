<?php
// Assuming your database connection is already established

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableNo = $_POST['tableNo'];

    // Update table status in the database (assuming your table structure and connection)
    $sql = "UPDATE bookings SET status = 'approved' WHERE table_no = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tableNo]);

    if ($stmt->rowCount() > 0) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
