<?php
// Include the database connection
include('connect.php');

session_start();

$admin = $_SESSION['admin'];

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$admin]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if (!isset($admin)) {
    header('location:login.php');
}

try {
    // Retrieve mm_event from POST data
    $mm_event = $_POST['mm_event'];
    $mm_eventname = $_POST['mm_eventname'];

    // Get the count of beneficiaries already added to this event
    $existingBeneficiariesCount = $conn->prepare("SELECT COUNT(*) AS count FROM medmissre WHERE mm_event = ?");
    $existingBeneficiariesCount->execute([$mm_event]);
    $countResult = $existingBeneficiariesCount->fetch(PDO::FETCH_ASSOC);
    $beneficiariesCount = $countResult['count'];

    $desiredBeneficiariesCount = 120;  // Set the desired number of beneficiaries

    if ($beneficiariesCount >= $desiredBeneficiariesCount) {
        echo "You have already added $desiredBeneficiariesCount beneficiaries for this event.";
    } else {
        $remainingBeneficiaries = $desiredBeneficiariesCount - $beneficiariesCount;
    
        // Check if all beneficiaries have been added to consecutive events
        $allBeneficiariesAdded = ($remainingBeneficiaries <= 0);
    
        if ($allBeneficiariesAdded) {
            $sql = "INSERT INTO medmissre (mm_event, mm_eventname, mmre_bentype, mmre_name, mmre_address, mmre_attend, mmevent)
                SELECT '$mm_event' AS mm_event, '$mm_eventname' AS mm_eventname, ben_type AS mmre_bentype, ben_name AS mmre_name, ben_address AS mmre_address, 'Yes' AS mmre_attend, 'Yes' AS mmevent
                FROM beneficiary
                WHERE ben_age >= 60 AND (ben_emptype = 'Part-time' OR ben_emptype = 'Unemployed')
                LIMIT $remainingBeneficiaries";
        } else {
            $sql = "INSERT INTO medmissre (mm_event, mm_eventname, mmre_bentype, mmre_name, mmre_address, mmre_attend, mmevent)
                SELECT '$mm_event' AS mm_event, '$mm_eventname' AS mm_eventname, ben_type AS mmre_bentype, ben_name AS mmre_name, ben_address AS mmre_address, 'Yes' AS mmre_attend, 'Yes' AS mmevent
                FROM beneficiary
                WHERE ben_name NOT IN (SELECT mmre_name FROM medmissre WHERE mm_event = '$mm_event')
                ORDER BY RAND()
                LIMIT $remainingBeneficiaries";
        }
    
        $conn->exec($sql);
    
        echo "Beneficiaries added successfully.";
    
        $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
        $auditlogin->execute(["admin", $fetch_profile['username'], "add beneficiaries to medical mission event"]);
    
        header("Refresh:0");
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>
