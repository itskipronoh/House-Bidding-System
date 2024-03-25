<?php
session_start();
include "conn.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST['email'])) {
    // Retrieve form data
    $surname = $_POST['surname'];
    $othernames = $_POST['othernames'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $idno = $_POST['idno'];
    $type = $_POST['type'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to insert user details
    $query = "INSERT INTO userdetails (surname, othernames, phone, email, idno, password, type) VALUES (:surname, :othernames, :phone, :email, :idno, :password, :type)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':othernames', $othernames);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':idno', $idno);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':type', $type);
    
    $result = $stmt->execute();

    // Check if insertion was successful
    if ($result) {
        $_SESSION['type'] = $type;
        $_SESSION['uid'] = $conn->lastInsertId(); // Set the session uid to the last inserted ID
        $_SESSION['username'] = $surname;

        // Redirect based on user type
        if ($type == "buyer") {
            header("Location: index.php");
        } elseif ($type == "seller") {
            header("Location: indexs.php");
        } elseif ($type == "admin") {
            header("Location: indexa.php");
        }
    } else {
        header("Location: register.php?regErr=Failed to register. Try again!");
    }
} else {
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HBS | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>HBS</b></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register here</p>
    <?php if(isset($_GET['regErr'])){echo '<div class="alert alert-danger">'.$_GET['regErr']. '</div>';} ?>
    <form action="" method="post">
	     
	<div class="form-group has-feedback">
        <input type="text" name="surname" class="form-control" placeholder="Surname" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>      
	<div class="form-group has-feedback">
        <input type="text" name="othernames" class="form-control" placeholder="Othernames" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>    
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
	<div class="form-group has-feedback">
        <input type="text" name="phone" class="form-control" placeholder="Phone No." required>
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="number" name="idno" class="form-control" placeholder="ID No." required>
        <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
      </div>
	<select class="form-group form-control" name="type" required>
                    <option value="">-Select User Type-</option>
                     <option value="buyer">Buyer</option>
                    <option value="seller">Seller</option>
                    
                  </select>
     <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password." required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
       </div> 
       <div class="form-group has-feedback">
        <input type="password" name="cpassword" class="form-control" placeholder="Confirm Password." required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
       </div> 
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <a href="login.php" class="text-center">I already registered</a>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
<?php } ?>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>