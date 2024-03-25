<?php
 include "header.php";
 include "conn.php";
 error_reporting(0);
    //fetch pending
    $sql3 = "SELECT COUNT(`house`.`hid`) as chid,`house`.`hid`,`house`.`type`,`house`.`time`,`house`.`price`,`house`.`availability`,`images`.`image`,`userdetails`.`surname`,`userdetails`.`othernames`,`userdetails`.`phone`,`userdetails`.`email` FROM `house`,`images`,`userdetails` WHERE `house`.`uid`=`userdetails`.`uid` AND `house`.`hid`=`images`.`hid` AND `house`.`status`='0' group by `images`.`hid` order by `house`.`hid` DESC";
    $query3 = mysqli_query($conn, $sql3) or die();
    $result3 = mysqli_num_rows($query3);
    //bid
    $hid = stripslashes($_REQUEST['ref']);
    $price = stripslashes($_REQUEST['price']);
    $uid = $_SESSION['uid'];
    if(isset($_REQUEST['approve']))
    {
      $sql1 ="UPDATE `house` SET `status`='1' WHERE `hid` = '$hid'";  
      $query1 = mysqli_query($conn, $sql1) or die();
      if($query1)
      {
        header("Location: indexa.php");
        $appr=("<span class='alert alert-success'>Post Approved Successfully!</span>");
      }
      else
      {
        header("Location: indexa.php?bidmsg=<span class='alert alert-danger'>Failed to Approve. Try again!</span>");
      }
    }
    if(isset($_REQUEST['reject']))
    {
      $sql1 ="UPDATE `house` SET `status`='2' WHERE `hid` = '$hid'";  
      $query1 = mysqli_query($conn, $sql1) or die();
      if($query1)
      {
        header("Location: indexa.php");
        $appr=("<span class='alert alert-success'>Post Rejected Successfully!</span>");
      }
      else
      {
        header("Location: indexa.php?bidmsg=Failed to Reject. Try again!");
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
          <?php if(isset($appr)){ echo $appr;}?>
            <div class="row">
            <?php while($row_pend = mysqli_fetch_assoc($query3)) { ?>
            
             <div class="col-md-6">
	      <div class="box box-default">
               <div class="box-header">
                <h3 class="box-title"> <?php echo $row_pend['type'];?></h3>
		           <div class="box-tools pull-right">
                Ref.#<?php echo $row_pend['hid'];?>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <a href="postdets.php?hid=<?php echo $row_pend['hid'];?>"><img src='dist/img/<?php echo $row_pend['image'];?>' alt="Img" class="img-responsive pad">
             <?php echo "KES." .$row_pend['price'].".00".". Owned by ".$row_pend['surname']." of ".$row_pend['phone']; ?></a>
             <br><small><?php echo "Posted on " .$row_pend['time'];?></small>
             <form name="status" action="" method="post">
             <input type="hidden" name="ref" value="<?php echo $row_pend['hid'];?>">
             <button type="submit" name="approve" class="btn btn-sm btn-success pull-right"style="margin-right:10px;"> Approve </button>
               <button type="submit" name="reject" class="btn btn-sm btn-danger pull-right"style="margin-right:10px;"> Reject </button>
               </form>
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
<?php
 include "footer.php";
?>
