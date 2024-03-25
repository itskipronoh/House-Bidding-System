<?php
include "header.php";
include "conn.php";



// Check if uid is set in session
if(empty($_SESSION['uid'])) {
    echo "Error: Session uid is not set.";
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Process image upload
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["file"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["file"]["tmp_name"]);
      if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
  }

  // Check file size
  if ($_FILES["file"]["size"] > 5000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }

  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
          echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
          // Insert post into database
          // Insert post into database
try {
    $type = $_POST['type'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $availability = isset($_POST['availability']) ? 1 : 0;
    $image = $target_file; // Store the path to the image file
    $time = date('Y-m-d H:i:s'); // Get the current timestamp

    // Insert post into database
    $sql = "INSERT INTO house(type, time, price, description, availability, uid, image) 
            VALUES (:type, :time, :price, :description, :availability, :uid, :image)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':availability', $availability);
    $stmt->bindParam(':uid', $_SESSION['uid']);
    $stmt->bindParam(':image', $image);
    $stmt->execute();

    echo "Post added successfully.";
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }
}


// Fetch user's posts
$sql3 = "SELECT hid, type, time, price, availability, image FROM house WHERE uid = :uid ORDER BY hid DESC";
$stmt3 = $conn->prepare($sql3);
$stmt3->bindParam(':uid', $_SESSION['uid']);
$stmt3->execute();
$posts = $stmt3->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <h1>
        Add Post
        <small>My posts</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-dashboard"></i> Posts</a></li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Enter Details Below</h3>
        </div>
        <div class="box-body">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">
                    <?php if(isset($posterr)){ echo $posterr;}?>
                    <form action="post.php" method="post" enctype="multipart/form-data">
                        <div class="form-group has-feedback">
                            <input type="text" name="type" class="form-control" placeholder="Type" required>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" name="price" class="form-control" placeholder="Price" required>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="availability" type="checkbox" value="1">
                                Available?
                            </label>
                        </div>
                        <div class="form-group has-feedback">
                            <textarea name="description" class="form-control" placeholder="Description" required></textarea>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <button type="reset" class="btn btn-default pull-left">Reset</button>
                        <button type="submit" class="btn btn-primary pull-right" name="post">Post</button>
                    </form>
                </div>
            </div>
            <section class="content">
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title">My Posts</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                        <?php foreach($posts as $post) { ?>
                            <div class="col-md-6">
                                <div class="box box-default">
                                    <div class="box-header">
                                        <h3 class="box-title"><?php echo $post['type'];?></h3>
                                        <div class="box-tools pull-right">
                                            Ref.#<?php echo $post['hid'];?>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <a href="editpost.php?hid=<?php echo $post['hid'];?>">
                                            <img src='<?php echo $post['image'];?>' alt="Img" class="img-responsive pad">
                                            <?php echo "KES." .$post['price'].".00"; ?>
                                        </a>
                                        <br><small><?php echo "Posted on " .$post['time'];?></small>
                                    </div>
                                </div>		
                            </div>
                        <?php } ?>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
