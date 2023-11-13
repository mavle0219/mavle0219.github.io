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
    // Retrieve ss_event and ss_numberofben from POST data
    $ss_event = $_POST['ss_event'];
    $ss_eventname = $_POST['ss_eventname'];
    $numberofben = $_POST['ss_numberofben'];

    // Get the count of beneficiaries already added to this event
    $existingBeneficiariesCount = $conn->prepare("SELECT COUNT(*) AS count FROM secsanre WHERE ss_event = ?");
    $existingBeneficiariesCount->execute([$ss_event]);
    $countResult = $existingBeneficiariesCount->fetch(PDO::FETCH_ASSOC);
    $beneficiariesCount = $countResult['count'];

    if ($beneficiariesCount >= $numberofben) {
        echo "You have already added $numberofben beneficiaries for this event.";
    } else {
        $remainingBeneficiaries = $numberofben - $beneficiariesCount;

        // Check if all beneficiaries have been added to consecutive events
        $allBeneficiariesAdded = ($remainingBeneficiaries <= 0);

        if ($allBeneficiariesAdded) {
            $sql = "INSERT INTO secsanre (ss_event, ss_eventname, ssre_bentype, ssre_name, ssre_address, ssre_attend, ssevent)
                SELECT '$ss_event' AS ss_event, '$ss_eventname' AS ss_eventname, ben_type AS ssre_bentype, ben_name AS ssre_name, ben_address AS ssre_address, 'Yes' AS ssre_attend, 'Yes' AS ssevent
                FROM beneficiary
                WHERE ben_age >= 60 AND (ben_emptype = 'Part-time' OR ben_emptype = 'Unemployed')
                LIMIT $remainingBeneficiaries";
        } else {
            $sql = "INSERT INTO secsanre (ss_event, ss_eventname, ssre_bentype, ssre_name, ssre_address, ssre_attend, ssevent)
                SELECT '$ss_event' AS ss_event, '$ss_eventname' AS ss_eventname, ben_type AS ssre_bentype, ben_name AS ssre_name, ben_address AS ssre_address, 'Yes' AS ssre_attend, 'Yes' AS ssevent
                FROM beneficiary
                WHERE ben_name NOT IN (SELECT ssre_name FROM secsanre WHERE ss_event = '$ss_event')
                ORDER BY RAND()
                LIMIT $remainingBeneficiaries";
        }

        $conn->exec($sql);

        $auditlogin = $conn->prepare("INSERT INTO `audit`(role, username, action) VALUES(?,?,?)");
        $auditlogin->execute(["admin", $fetch_profile['username'], "add beneficiaries to secret santa event"]);

        header("Refresh:0");
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>