<?php
include 'connect.php';

$user = $_SESSION['user'];

if (!isset($user)) {
  header('location:login.php');
}

if (isset($_POST['search'])) {

?>


    <!-- Hoverable Table rows -->
    <div class="card">
        <div class="table-responsive text-nowrap" style="max-height: 585px; overflow-y: auto;">
            <table id="data-table" class="table table-hover">
            <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
                    <tr>
                        <th>Event Date</th>
                        <th>Event Name</th>
                        <th>Creator</th>
                        <th>Creation Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $keyword = $_POST['keyword'];
                    $query = $conn->prepare("SELECT * FROM `secsan` WHERE `ss_event` LIKE '%$keyword%' or `ss_eventname` LIKE '%$keyword%' or `ss_creator` LIKE '%$keyword%' or
    `ss_date` LIKE '%$keyword%'");
                    $query->execute();
                    while ($row = $query->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['ss_event']; ?></td>
                            <td><?php echo $row['ss_eventname']; ?></td>
                            <td><?php echo $row['ss_creator']; ?></td>
                            <td><?php echo $row['ss_date']; ?></td>
                            <td>
                            <a href="newsecsanre.php?ss_id=<?= $row['ss_id'] ?>"><span class="badge bg-label-info">View Recipients</span></a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
} else {
?>
    <div class="card">
        <div class="table-responsive text-nowrap" style="max-height: 585px; overflow-y: auto;">
            <table id="data-table" class="table table-hover">
                <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
                    <tr>
                        <th>Event Date</th>
                        <th>Event Name</th>
                        <th>Creator</th>
                        <th>Creation Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $sql = "SELECT * FROM `secsan`";
                    $result = $conn->prepare($sql);
                    $result->execute();
                    while ($row = $result->fetch()) {
                    ?>
                        <tr>
                            <td><?php echo $row['ss_event']; ?></td>
                            <td><?php echo $row['ss_eventname']; ?></td>
                            <td><?php echo $row['ss_creator']; ?></td>
                            <td><?php echo $row['ss_date']; ?></td>
                            <td>
                            <a href="newsecsanre.php?ss_id=<?= $row['ss_id'] ?>"><span class="badge bg-label-info">Vieww Recipients</span></a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Hoverable Table rows -->

<?php
}
?>

<script>
function confirmDelete(ssId) {
    if (confirm("Are you sure you want to delete this event?")) {
        // If user confirms, navigate to adelben.php with the beneficiary ID
        window.location.href = "adelsecsandon.php?ss_id=" + ssId;
    }
}
</script>