<?php
// Include your database connection
include 'connect.php';

// Fetch events from MariaDB
$sql = "SELECT id, title, start_date, end_date FROM events";
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $row['start_date'],
            'end' => $row['end_date']
        );
    }
}

// Output the events in JSON format
header('Content-Type: application/json');
echo json_encode($events);
?>
