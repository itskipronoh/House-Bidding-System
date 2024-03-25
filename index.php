<?php
include "header.php";
include "conn.php";
error_reporting(0);

// Fetch posts from the database
$query = $conn->prepare("SELECT * FROM house");
$query->execute();
$posts = $query->fetchAll(PDO::FETCH_ASSOC);

// Bid submission
if (isset($_POST['price']) && isset($_POST['hid'])) {
    // Retrieve form data
    $hid = $_POST['hid'];
    $price = $_POST['price'];
    $uid = $_SESSION['uid'];

    // Prepare SQL statement to insert bid data
    $sql = "INSERT INTO bid (bidprice, uid, hid, time, status) VALUES (:bidprice, :uid, :hid, CURRENT_TIMESTAMP, 0)";
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
                <?php foreach ($posts as $post) : ?>
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo $post['type']; ?></h3>
                                <div class="box-tools pull-right">
                                    Ref.#<?php echo $post['hid']; ?>
                                </div>
                            </div>
                            <div class="box-body">
                                <a href="postdets.php?hid=<?php echo $post['hid']; ?>">
                                    <img src='<?php echo $post['image']; ?>' alt="Img" class="img-responsive pad"> <!-- Assuming image column exists in house table -->
                                    <?php echo "KES." . $post['price'] . ".00"; ?>
                                </a>
                                <br><small><?php echo "Posted on " . $post['time']; ?></small>
                                <button data-toggle="modal" data-target="#modal-<?php echo $post['hid']; ?>" class="btn btn-sm btn-success pull-right" style="margin-right:10px;"> Bid </button>
                                <div class="modal fade" id="modal-<?php echo $post['hid']; ?>">
                                    <!-- Modal content for placing bid -->
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
                        </div>
                    </div>
                <?php endforeach; ?>
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
<?php
include "footer.php";
?>
