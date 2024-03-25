<?php
include "header.php";
include "conn.php";

//fetch my bids
$uid = $_SESSION['uid'];
$sql3 = "SELECT bid.bidprice, bid.time, bid.status, house.type, userdetails.surname, userdetails.othernames, userdetails.email, userdetails.phone 
         FROM bid
         INNER JOIN house ON house.hid = bid.hid
         INNER JOIN userdetails ON userdetails.uid = house.uid
         WHERE bid.uid = :uid";

$query3 = $conn->prepare($sql3);
$query3->bindParam(':uid', $uid);
$query3->execute();
$result3 = $query3->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        My Bids
        <small>Bid lists</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-dashboard"></i> Posts</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
        </div>
        <div class="box-body">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">
                    Filter by House Type on input above OR Search by anything on the right Search
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered table-striped no-padding" id="myTable">
                            <thead>
                                <tr>
                                    <th>House Type</th>
                                    <th>Owner Phone</th>
                                    <th>Owner Mail</th>
                                    <th>Bid Price</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result3 as $row_mybid) : ?>
                                    <tr>
                                        <td><?php echo $row_mybid['type']; ?></td>
                                        <td><?php echo $row_mybid['phone']; ?></td>
                                        <td><?php echo $row_mybid['email']; ?></td>
                                        <td><?php echo $row_mybid['bidprice']; ?></td>
                                        <td><?php echo $row_mybid['time']; ?></td>
                                        <td><?php
                                            if ($row_mybid['status'] == 1) {
                                                echo '<span class="label label-success">Approved</span>';
                                            } else if ($row_mybid['status'] == 2) {
                                                echo '<span class="label label-danger">Rejected</span>';
                                            } else {
                                                echo '<span class="label label-warning">Pending</span>';
                                            }
                                            ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
</div>
<!-- /.container -->
</div>
<!-- /.content-wrapper -->

<!-- ./wrapper -->
<script>
    function myFunction() {
        // Declare variables 
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
<?php
include "footer.php";
?>
