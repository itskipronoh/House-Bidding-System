<?php
 include "header.php";
 include "conn.php";
 error_reporting(0);
      $url = $_GET['hid'];
     //fetch my posts
    $sql3 = "SELECT `house`.`hid`,`house`.`type`,`house`.`time`,`house`.`price`,`house`.`availability` FROM `house` WHERE  `house`.`hid`='$url' order by `house`.`hid` DESC";
    $query3 = mysqli_query($conn, $sql3) or die();
    $row_post = mysqli_fetch_assoc($query3);
    $result3 = mysqli_num_rows($query3);
    
    //image in
    if(isset($_REQUEST['upload']))
    {
    
        foreach ($_FILES["files"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK ){
                $name = $lastid.$_FILES['files']['name'][$key];
                $target_dir = "dist/img/";
                $sql2 = "INSERT INTO images(image,hid) VALUES ('".$name."','$url')";
                $result2 = mysqli_query($conn,$sql2) or die(mysqli_error($conn));
                move_uploaded_file($_FILES['files']['tmp_name'][$key],$target_dir.$name);
                $uperror= ("<span class='alert alert-success'>Files uploaded successfully. Await for admins approval</span>");
            }
            else{
              $uperror = ("<span class='alert alert-danger'>Failed to upload files. Try again!</span>");
            }
        }
      }
    
?>
<!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Add Images
          <small>My posts</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="#"><i class="fa fa-dashboard"></i>Posts</a></li>
         <li><a href="#"><i class="fa fa-dashboard"></i>Edit Posts</a></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Ref# <?php  echo $_GET['hid'] ." posted on ". $row_post['time']; ?></h3>
            
          </div>
          <div class="box-body">
            
            <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Select Multiple Images</h3>
            
          </div>
          <div class="box-body">
          <?php if(isset($uperror)){ echo $uperror;}?>
           <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <input type="text" name="type" class="form-control" placeholder="Type" value="<?php  echo $row_post['type']; ?>" disabled>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
       <div class="form-group has-feedback">
        <input type="file" name="files[]" class="form-control" placeholder="Image #1" multiple required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      
      
      <button type="reset" class="btn btn-default pull-left">Reset</button>
                <button type="submit" name="upload" class="btn btn-primary pull-right">Post</button>
      </form>
          </div>

          </div>
          <!-- /.box-body -->
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
