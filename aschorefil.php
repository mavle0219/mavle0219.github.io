<?php
include 'connect.php';

// Assuming $conn is your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["filter"])) {
    $schoolYearFilter = $_POST['c_sy'];
    $monthFilter = $_POST['c_month'];

    // Assuming the names of your columns in the claim table
    $select_query = "SELECT * FROM claim WHERE c_sy = ? AND c_month = ?";
    $select_statement = $conn->prepare($select_query);
    $select_statement->execute([$schoolYearFilter, $monthFilter]);

    // Check if any rows are returned
    if ($select_statement->rowCount() > 0) {
        // Output the HTML table rows
        while ($row = $select_statement->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td></td>"; // Add your row data here based on your table structure
            echo "<td>{$row['c_name']}</td>";
            echo "<td>{$row['c_sy']}</td>";
            echo "<td>{$row['c_month']}</td>";
            echo "<td>{$row['c_claim']}</td>";
            echo "</tr>";
        }
    } else {
        // No records found
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
}
?>
