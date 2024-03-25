<?php
 include "header.php";
 include "conn.php";
 error_reporting(0);
    //fetch my bids
    $uid = $_SESSION['uid'];
    $sql3 = "SELECT * FROM userdetails";
    $query3 = mysqli_query($conn, $sql3) or die();
    $result3 = mysqli_num_rows($query3);
    //users
    //approve
    $cuid = $_REQUEST['cuid'];
    if(isset($_REQUEST['app']))
    {
      
      $sql2 ="UPDATE `userdetails` SET `status`='1' WHERE `uid`='$cuid'";  
      $query2= mysqli_query($conn, $sql2) or die();
      if($query2)
      {
        header("Location: users.php");
        $edit=("<span class='alert alert-dismissible alert-success'>User Approved Successfully!</span>");
      }
      else
      {
        header("Location: users.php");
         $edit=("<span class='alert alert-danger'>Failed to Approve. Try again!</span>");
      }
    }
    //reject
    else
    if(isset($_REQUEST['rej']))
    {
      $sql2 ="UPDATE `userdetails` SET `status`='2' WHERE `uid`='$cuid'";  
      $query2= mysqli_query($conn, $sql2) or die();
      if($query2)
      {
        header("Location: users.php");
        $edit=("<span class='alert alert-success'>User Rejected Successfully!</span>");
      }
      else
      {
        header("Location: users.php");
         $edit=("<span class='alert alert-danger'>Failed to Reject. Try again!</span>");
      }
    }
    //admin
    else if(isset($_REQUEST['adm']))
    {
      $sql2 ="UPDATE `userdetails` SET `type`='admin' WHERE `uid`='$cuid'";  
      $query2= mysqli_query($conn, $sql2) or die();
      if($query2)
      {
        header("Location: users.php");
        $edit=("<span class='alert alert-success'>Admin Added Successfully!</span>");
      }
      else
      {
        header("Location: users.php");
         $edit=("<span class='alert alert-danger'>Failed to Add privilege. Try again!</span>");
      }
    }
?>
<!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          All Users
          <small>User list</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="#"><i class="fa fa-dashboard"></i> Users</a></li>
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
            <?php if(isset($edit)){echo $edit;}?>
            Filter by S/NO on input above OR Search by anything on the right Search
                <div class="box-body table-responsive ">
              <table class="table table-hover table-bordered table-striped table-responsive no-padding" id="myTable">
                <thead><tr>
                  <th>S/No</th>
                  <th>Full Name</th>
                  <th>ID No.</th>                 
                  <th>Email Address</th>
                  <th>Phone No.</th>
                  <th>User Type</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr></thead><?php while($row_mybid = mysqli_fetch_assoc($query3)) { ?>
                <tr>
                  <td><?php echo $row_mybid['uid'];?></td>
                  <td><?php echo $row_mybid['surname'] . " " .$row_mybid['othernames'];?></td>
                  <td><?php echo $row_mybid['idno'];?></td>
                  <td><?php echo $row_mybid['email'];?></td>
                  <td><?php echo $row_mybid['phone'];?></td>
                  <td><?php echo $row_mybid['type'];?></td>
                  <td><?php if($row_mybid['status'] == 1){ echo '<span class="label label-success">Approved</span>';} else
                  if($row_mybid['status'] == 2){ echo '<span class="label label-danger">Rejected</span>';}else {echo '<span class="label label-warning">Pending</span>';}?></td>
                  <td>
                  <form action="" method="post">
                  <input type="hidden" name="cuid" value="<?php echo $row_mybid['uid'];?>">
                  
                  <?php if($row_mybid['status'] == 2){ print '
                      <div class="btn-group">
                      <button type="submit" name="app" class="btn btn-success" onsubmit="return confirm("Approve User?")">Approve</button>
                      <button type="submit" name="rej" class="btn btn-danger">Reject</button>
                      <button type="submit" name="adm" class="btn btn-warning">Make Admin</button>
                      </div>';} else
                      if($row_mybid['status'] == 1){ print '
                      <div class="btn-group">
                        <button type="submit" name="app" class="btn btn-success disabled">Approve</button>
                      <button type="submit" name="rej" class="btn btn-danger">Reject</button>
                      <button type="submit" name="adm" class="btn btn-warning">Make Admin</button>
                      </div>';}
                      else  if($row_mybid['status'] == 0){ print '
                      <div class="btn-group">
                        <button type="submit" name="app" class="btn btn-success" onsubmit="return confirm("Approve User?")">Approve</button>
                      <button type="submit" name="rej" class="btn btn-danger disabled">Reject</button>
                      <button type="submit" name="adm" class="btn btn-warning">Make Admin</button>
                      </div>';}
                      else  if($row_mybid['type'] == "admin"){ print '
                      <div class="btn-group">
                      <button type="submit" name="app" class="btn btn-success" onsubmit="return confirm("Approve User?")">Approve</button>
                      <button type="submit" name="rej" class="btn btn-danger">Reject</button>
                      <button type="submit" name="rem" class="btn btn-danger disabled">Strip Admin</button>
                      </div>';}?>
                    
                    </form>
                 </td>
                </tr>
               <?php } ?>
              </tbody></table>
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
