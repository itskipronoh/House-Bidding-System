<?php
include "header.php";
include "conn.php";
error_reporting(0);

// Assuming you have a user ID stored in $_SESSION['uid']
$seller_uid = $_SESSION['uid'];

// Fetch bid details for houses posted by the specific seller
$query = $conn->prepare("SELECT b.*, h.type, u.phone, u.email FROM bid b INNER JOIN house h ON b.hid = h.hid INNER JOIN userdetails u ON b.uid = u.uid WHERE h.uid = :seller_uid");
$query->bindParam(':seller_uid', $seller_uid);
$query->execute();
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
                    <small>Filter by Ref# on input above OR Search by anything on the right Search</small><br>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered table-striped no-padding" id="myTable">
                            <thead>
                                <tr>
                                    <th>Ref#</th>
                                    <th>House Type</th>
                                    <th>Owner Phone</th>
                                    <th>Owner Mail</th>
                                    <th>Bid Price</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td><?php echo $row['hid']; ?></td>
                                        <td><?php echo $row['type']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['bidprice']; ?></td>
                                        <td><?php echo $row['time']; ?></td>
                                        <td>
                                            <?php
                                            if($row['status'] == 1) {
                                                echo '<span class="label label-success">Approved</span>';
                                            } elseif($row['status'] == 2) {
                                                echo '<span class="label label-danger">Rejected</span>';
                                            } else {
                                                echo '<span class="label label-warning">Pending</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="cuid" value="<?php echo $row['bid']; ?>">
                                                <?php
                                                if($row['status'] == 1) {
                                                    echo '<div class="btn-group">
                                                        <button type="button" class="btn btn-success disabled">Approve</button>
                                                        <button type="submit" name="rej" class="btn btn-danger">Reject</button>
                                                    </div>';
                                                } elseif($row['status'] == 2) {
                                                    echo '<div class="btn-group">
                                                        <button type="submit" name="app" class="btn btn-success">Approve</button>
                                                        <button type="button" class="btn btn-danger disabled">Reject</button>
                                                    </div>';
                                                } else {
                                                    echo '<div class="btn-group">
                                                        <button type="submit" name="app" class="btn btn-success">Approve</button>
                                                        <button type="submit" name="rej" class="btn btn-danger">Reject</button>
                                                    </div>';
                                                }
                                                ?>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<!-- /.content -->

<?php
include "footer.php";

// Handle form submission for updating bid status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted
    if (isset($_POST['app']) || isset($_POST['rej'])) {
        // Check if either approve or reject button was clicked

        // Retrieve the bid ID from the form submission
        $bid_id = $_POST['cuid'];

        // Determine the new status based on the button clicked
        $new_status = isset($_POST['app']) ? 1 : 2; // 1 for approved, 2 for rejected

        // Prepare SQL statement to update the bid status
        $sql = "UPDATE bid SET status = :new_status WHERE bid_id = :bid_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':new_status', $new_status);
        $stmt->bindParam(':bid_id', $bid_id);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Redirect back to the page after updating the status
            header("Location: my_bids.php");
            exit(); // Stop further execution
        } else {
            // Handle error if the update fails
            echo "Error updating bid status.";
        }
    }
}
?>
