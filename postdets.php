<?php
include "header.php";
include "conn.php";

// Check if house ID is provided in the URL parameter
if (isset($_GET['hid'])) {
    $hid = $_GET['hid'];

    // Fetch data of the specified house from the database
    $query = $conn->prepare("SELECT h.*, u.surname, u.othernames, u.phone, u.email FROM house h INNER JOIN userdetails u ON h.uid = u.uid WHERE h.hid = :hid");
    $query->bindParam(':hid', $hid);
    $query->execute();
    $row_post = $query->fetch(PDO::FETCH_ASSOC);
}

// Bid submission
if (isset($_POST['price']) && isset($_POST['hid'])) {
  // Retrieve form data
  $hid = $_POST['hid'];
  $price = $_POST['price'];
  $uid = $_SESSION['uid'];

  // Prepare SQL statement to insert bid data
  $sql = "INSERT INTO bid (bidprice, uid, hid, time, status) VALUES (:bidprice, :uid, :hid, CURRENT_TIMESTAMP, 1)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':bidprice', $price);
  $stmt->bindParam(':uid', $uid);
  $stmt->bindParam(':hid', $hid);

  // Execute SQL statement
  if ($stmt->execute()) {
      header("Location: index.php?bidmsg=Bid placed Successfully!");
      exit(); // Stop further execution
  } else {
      header("Location: index.php?bidmsg=Failed to place bid. Try again!");
      exit(); // Stop further execution
  }
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Houses
        <small>House Details</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-dashboard"></i> Posts Details</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $row_post['type']; ?> <?php echo " KES." . $row_post['price'] . ".00" . ". Owned by " . $row_post['surname'] . " of " . $row_post['phone']; ?>
                <br><small><?php echo "Posted on " . $row_post['time']; ?></small></h3>
            <div class="box-tools pull-right">
                Ref.#<?php echo $row_post['hid'] . "  "; ?>
                &nbsp;<button data-toggle="modal" data-target="#modal-default" class="btn btn-sm btn-success pull-right" style="margin-right:10px;"> Bid </button>
            </div>
        </div>
        <div class="box-body">
            <?php if (isset($bidmsg)) {
                echo $bidmsg;
            } ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-body">
                            <img src='<?php echo $row_post['image']; ?>' alt="Img" class="img-responsive pad">
                            <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Place Bid</h4>
                                            </div>
                                            <form name="bid" action="index.php" method="post"> <!-- Make sure the action attribute points to the correct file -->
                                                <div class="modal-body">
                                                    <div class="form-group has-feedback">
                                                        <input type="hidden" name="hid" value="<?php echo $post['hid']; ?>"> <!-- Add a hidden input field for house ID -->
                                                        <input type="number" name="price" class="form-control" placeholder="Bid Price" required>
                                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Place Bid</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
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
<?php include "footer.php"; ?>
