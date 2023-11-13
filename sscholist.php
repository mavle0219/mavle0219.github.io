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
                <th>Scholar ID</th>  
                <th>Full Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
$keyword = $_POST['keyword'];
    $query = $conn->prepare("SELECT * FROM `scholar` WHERE `sch_name` LIKE '%$keyword%' or `sch_age` LIKE '%$keyword%' or
    `sch_address` LIKE '%$keyword%'");
    $query->execute();
    while ($row = $query->fetch()) {
        ?>
                <tr>
                <td><?php echo $row['ben_type']; ?></td>
                <td><?php echo $row['sch_name']; ?></td>
                <td><?php echo $row['sch_age']; ?></td>
                <td><?php echo $row['sch_address']; ?></td>
                <td><a href="schoprof.php?sch_id=<?=$row['sch_id']?>"><span class="badge bg-label-info">View</span></a></td>
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
                <th>Scholar ID</th> 
                <th>Full Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php

    $sql = "SELECT * FROM `scholar`";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch()) {
        ?>
                <tr>
                <td><?php echo $row['ben_type']; ?></td>
                <td><?php echo $row['sch_name']; ?></td>
                <td><?php echo $row['sch_age']; ?></td>
                <td><?php echo $row['sch_address']; ?></td>
                <td><a href="schoprof.php?sch_id=<?=$row['sch_id']?>"><span class="badge bg-label-info">View</span></a></td>
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
