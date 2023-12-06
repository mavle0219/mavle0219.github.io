<?php
include 'connect.php';

$admin = $_SESSION['admin'];

if (!isset($admin)) {
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
                        <th>Beneficiary ID</th>
                        <th>Full Name</th>
                        <th>Archive Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $keyword = $_POST['keyword'];
                    $query = $conn->prepare("SELECT * FROM `beneficiary` WHERE (`ben_name` LIKE '%$keyword%' OR `ben_ad` LIKE '%$keyword%') AND `ben_arch` = 1 ORDER BY `ben_id`");
                    $query->execute();
                    $rowCount = $query->rowCount();

                    if ($rowCount > 0) {
                        while ($row = $query->fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $row['ben_type']; ?></td>
                                <td><?php echo $row['ben_name']; ?></td>
                                <td><?php echo $row['ben_ad']; ?></td>
                                <td><a href="#" onclick="confirmRestore(<?= $row['ben_id'] ?>)"><span
                                                class="badge bg-label-danger">Restore</span></a></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="6">No results found</td></tr>';
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
                        <th>Beneficiary ID</th>
                        <th>Full Name</th>
                        <th>Archive Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `beneficiary` where ben_arch = 1";
                    $result = $conn->prepare($sql);
                    $result->execute();
                    $rowCount = $result->rowCount();

                    if ($rowCount > 0) {
                        while ($row = $result->fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $row['ben_type']; ?></td>
                                <td><?php echo $row['ben_name']; ?></td>
                                <td><?php echo $row['ben_ad']; ?></td>
                                <td><a href="#" onclick="confirmRestore(<?= $row['ben_id'] ?>)"><span
                                                class="badge bg-label-danger">Restore</span></a></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="6">No results found</td></tr>';
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
    function confirmRestore(benId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will restore the beneficiary!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore it!',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                // Handle archiving directly on the same page
                restoreBeneficiary(benId);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // User canceled, show cancellation message
                Swal.fire({
                    title: 'Cancelled',
                    text: 'No changes made!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    // Function to handle archiving
    function restoreBeneficiary(benId) {
        // You can use AJAX to send a request to the server for archiving
        // Alternatively, you can redirect to the archiving script on the server
        window.location.href = "archben.php?ben_id=" + benId;
    }
</script>
