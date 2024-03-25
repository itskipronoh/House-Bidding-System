<?php
include "header.php";
include "conn.php";

// Assuming you have a user ID stored in $_SESSION['uid']
$uid = $_SESSION['uid'];

// Fetch houses posted by the user
$query = $conn->prepare("SELECT h.*, u.surname, u.othernames, u.phone, u.email FROM house h INNER JOIN userdetails u ON h.uid = u.uid WHERE h.uid = :uid");
$query->bindParam(':uid', $uid);
$query->execute();
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Home
        <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Houses</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <?php while ($row_pend = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="col-md-6" id="col">
                        <div class="box box-default">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo $row_pend['type']; ?></h3>
                                <div class="box-tools pull-right">
                                    Ref.#<?php echo $row_pend['hid']; ?>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <a href="postdets.php?hid=<?php echo $row_pend['hid']; ?>"><img src='<?php echo $row_pend['image']; ?>' alt="Img" class="img-responsive pad">
                                    <?php echo "KES." . $row_pend['price'] . ".00" . ". Owned by " . $row_pend['surname'] . " of " . $row_pend['phone']; ?></a>
                                <br><small><?php echo "Posted on " . $row_pend['time']; ?></small>
                                <div class="modal fade" id="modal-<?php echo $row_pend['hid']; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Place Bid</h4>
                                            </div>
                                            <form action="" method="post">
                                                <div class="modal-body">
                                                    <div class="form-group has-feedback">
                                                        <input type="number" name="ref" class="form-control" placeholder="Ref#" required>
                                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <input type="number" name="price" class="form-control" placeholder="Bid Price" required>
                                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                                    </div>
                                                    <input type="hidden" name="hid" value="<?php echo $row_pend['hid']; ?>" required>
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
                <?php } ?>
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
