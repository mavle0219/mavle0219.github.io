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
    <div id="data-table" class="table-responsive text-nowrap" style="max-height: 585px; overflow-y: auto;">
        <table class="table table-hover">
        <thead style="position: sticky; top: 0; background-color: #7e8a9b; z-index: 1;">
                <tr>
                <th>Beneficiary ID</th>  
                <th>Full Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
$keyword = $_POST['keyword'];
    $query = $conn->prepare("SELECT * FROM `beneficiary` WHERE `ben_name` LIKE '%$keyword%' or `ben_age` LIKE '%$keyword%' or
    `ben_address` LIKE '%$keyword%' and ben_ma = 'Yes'");
    $query->execute();
    while ($row = $query->fetch()) {
        ?>
                <tr>
                <td><?php echo $row['ben_type']; ?></td>
                <td><?php echo $row['ben_name']; ?></td>
                <td><?php echo $row['ben_age']; ?></td>
                <td><?php echo $row['ben_address']; ?></td>
                <td><a href="abenprof.php?ben_id=<?=$row['ben_id']?>"><span class="badge bg-label-info">View</span></a></td>
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
                <th>Beneficiary ID</th> 
                <th>Full Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php

    $sql = "SELECT * FROM `beneficiary` where ben_ma = 'Yes'";
    $result = $conn->prepare($sql);
    $result->execute();
    while ($row = $result->fetch()) {
        ?>
                <tr>
                <td><?php echo $row['ben_type']; ?></td>
                <td><?php echo $row['ben_name']; ?></td>
                <td><?php echo $row['ben_age']; ?></td>
                <td><?php echo $row['ben_address']; ?></td>
                <td><a href="abenprof.php?ben_id=<?=$row['ben_id']?>"><span class="badge bg-label-info">View</span></a></td>
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