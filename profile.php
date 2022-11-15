<?php
include_once('checkuser.php');
?>

<!doctype html>
<html lang="en">

<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link rel="shortcut icon" type="x-icon" href="img/University_of_Pangasinan_logo.png">

  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">-->

  <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

  <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

</head>
<style>
  body {
    margin: 0;
    font-family: "Lato", sans-serif;
  }

  .sidenav {
    height: 100%;
    left: 0;
    background-color: #f1f1f1;
  }

  .sidenav a {
    display: block;
    color: black;
    padding: 16px;
    text-decoration: none;
  }

  .sidenav a.active {
    background-color: #04AA6D;
    color: white;
  }

  .sidenav a:hover:not(.active) {
    background-color: #555;
    color: white;
  }

  div.content {
    margin-top: 50px;
    margin-left: 200px;
    padding: 9%;
    display: flex;
    justify-content: center;
  }

  form {
    width: 100%;

    padding: 20px;
    background: #fff;
    border-radius: 15px;
  }

  form h1,
  h4,
  img,
  button {
    text-align: center;
  }

  input {
    display: block;
    border: 2px solid #ccc;
    width: 95%;
    padding: 10px;
    margin: 10px auto;
    border-radius: 5px;
  }

  button {
    background: #555;
    padding: 10px 15px;
    color: #fff;
    border-radius: 5px;
    border: none;
    margin-left: 27%;
  }

  button:hover {
    opacity: .7;
  }

  .editbtn {
    margin: auto;
    display: block;
  }

  .deletebtn {
    margin: auto;
    display: block;
  }






  @media screen and (max-width: 700px) {
    .sidebar {
      width: 100%;
      height: auto;
      position: relative;
      margin-top: 50px;
    }

    .sidebar a {
      float: left;
    }

    div.container-fluid {
      margin-left: 0;
    }

  }

  @media screen and (max-width: 400px) {
    .sidebar a {
      text-align: center;
      float: none;
    }

    .sidebar {
      margin-top: 50px;
    }

    div.container-fluid {
      width: 100%;
    }
  }

  .buttons-print {

    color: #fff;
  }

  footer {
    bottom: 0;
    width: 100%;
    height: 2.5rem;
    /* Footer height */
  }
</style>

<body>
  <?php
  include_once('checkuser.php');
  ?>
  <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #D5AA36;margin-bottom: 0px;border-bottom-width: 0px;">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#" style="
    padding-bottom: 0px;
    padding-left: 0px;
    padding-top: 0px;
    padding-right: 0px;
    width: 50px;
"><img height="20" width="30" src="img/University_of_Pangasinan_logo.png" alt="" style="
    width: 50px;
    height: 50px;
"></a>
        <p class="navbar-text navbar-right">Feedback</p>
      </div>

      <?php
      $connection = mysqli_connect("localhost", "root", "");
      $db = mysqli_select_db($connection, 'dbscholarship');

      $query = "SELECT * FROM scholarshiprequest WHERE notifstatus=0 AND notiffor LIKE 'Admin'";
      $query_run = mysqli_query($connection, $query);
      $count = mysqli_num_rows($query_run);
      ?>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="bi bi-bell-fill"></i><span class="badge"><?php echo $count; ?></span>
            </a>
            <ul class="dropdown-menu">
              <?php
              $connection = mysqli_connect("localhost", "root", "");
              $db = mysqli_select_db($connection, 'dbscholarship');
              $query = "SELECT * FROM scholarshiprequest WHERE notifstatus=0 AND notiffor LIKE 'Admin'";
              $query_run = mysqli_query($connection, $query);
              if (mysqli_num_rows($query_run) > 0) {
                while ($result = mysqli_fetch_assoc($query_run)) {
                  echo '<li><a href="scholarshiprequest.php">' . $result['notification'] . '</a></li>';
                  echo '<li role="separator" class="divider"></li>';
                }
              } else {
                echo '<li><a>No Notification</a></li>';
              }

              ?>

            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome <span class="text-success"><?php echo ucwords($_SESSION['NAME']); ?>
              </span> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="profile.php">Profile</a></li>
              <li><a href="changepassword.php">Change Password</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container-fluid" style="padding-top: 50px;">
    <div class="row">
      <div class="col-sm-2 sidenav">
        <a href="dashboardadmin.php"><i class="bi bi-mortarboard"></i> Dashboard</a>
        <a href="scholars.php"><i class="bi bi-mortarboard"></i> Scholars</a>
        <a href="scholarships.php"><i class="bi bi-mortarboard"></i> Scholarship</a>
        <a href="scholarshiprequest.php"><i class="bi bi-mortarboard"></i> Scholarship Request</a>
        <a href="announcement.php"><i class="bi bi-megaphone"></i> Announcement</a>
        <a href="feedback.php" class="active"><i class="bi bi-star"></i> Feedback</a>
        <a href="featured scholar.php"><i class="bi bi-mortarboard"></i> Featured Scholars</a>
        <a href="setings.php"><i class="bi bi-mortarboard"></i> Settings</a>
        <a href="useraccount.php"><i class="bi bi-person-plus"></i> User Accounts</a>
        <a href="userlogs.php"><i class="bi bi-mortarboard"></i> User Logs</a>

      </div>
      <div class="col-sm-10">
        <div class="container-fluid">
          <form class="form-horizontal" action="feedback.php" method="post" name="upload_excel" enctype="multipart/form-data">
            <fieldset>
              <!-- Form Name -->
              <legend>Feedback</legend>
              <!-- File Button -->
              <!-- Button -->
            </fieldset>
          </form>
        </div>
        <?php
        get_all_records();
        ?>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable();
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
  <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>



  <script>
    function alphaOnly(event) {
      var key = event.keyCode;
      return ((key >= 65 && key <= 90) || key == 8 || key == 9 || key == 32);
    };

    function numbersOnly(event) {
      var key = event.keyCode;
      return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 8 || key == 9 || key == 109 || key == 189);
    };
    $(function() {
      $('#myTable').DataTable({
        dom: "<'row'<'col-sm-1'<'btn btn-primary'B>><'col-sm-11'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-1'i>>",
        buttons: [{
          extend: 'print'
        }],
        "pageLength": 10,
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,

      });
    });
  </script>








  <section>
    <!-- Footer -->

    <!-- Footer -->
  </section>
</body>



</html>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Session Expiration</h4>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        Because you have been Inactivity, your session is about to expire.
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <a href="userlogin.php" class="btn btn-primary btn-sm">Login again</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  setInterval(check_user, 2000);

  function check_user() {
    $.ajax({
      url: 'checkuser.php',
      method: 'POST',
      data: 'type=logout',
      success: function(result) {
        if (result == "logout") {
          $("#myModal").modal({
            backdrop: 'static',
            keyboard: false,
          });
          setTimeout(function() {
            $('#myModal').modal('hide')
            window.location.href = "logout.php";
          }, 10000);
        }
      }
    });
  }
</script>
<?php


// Include database connectivity

include_once('config.php');

include_once('checkuser.php');


if (isset($_POST['submit'])) {

  $errorMsg = "";

  $id = $_SESSION['ID'];
  $contact = $con->real_escape_string($_POST['contact']);
  $email = $con->real_escape_string($_POST['email']);

  $datetime = date("Y-m-d H:i:s");
  $description = "Edit Profile";
  $author = $_SESSION['NAME'];

  $sql = "SELECT * FROM users WHERE id = '$id' ";

  $result = $con->query($sql);
  if (!empty($contact) && !empty($email)) {
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $update = "UPDATE users SET contactno = '$contact', emailaddress = '$email' WHERE id = '$id' ";
      $result = $con->query($update);
      $update = "INSERT INTO userlogs (`date`,`description`,`author`) VALUES ('$datetime','$description','$author')";
      $result = $con->query($update);
      $_SESSION['CONTACTNO'] = $row['contactno'];
      $_SESSION['EMAILADDRESS'] = $row['emailaddress'];
      $errorMsg = 'Information Changed Successfully';
    }
  } else {
    $errorMsg = "All fields is required";
  }
}

?>
<!doctype html>
<html lang="en">

<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link rel="shortcut icon" type="x-icon" href="img/University_of_Pangasinan_logo.png">

</head>

<body>
  <?php
  include_once('checkuser.php');
  ?>

  <!-- Modal -->
  <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <div class="modal-body">
          <form class="student_form" action="profile.php" method="post">
            <label for="contact">Contact No.</label>
            <input style="margin-bottom:5px; padding:8px;" type="text" placeholder="Contact No." name="contact" id="contact" value="<?php echo $_SESSION['CONTACTNO']; ?>">
            <label for="email">Email Address</label>
            <input style="margin-bottom:5px; padding:8px;" type="email" placeholder="Email" name="email" id="email" value="<?php echo $_SESSION['EMAILADDRESS']; ?>">
            <input style="margin-bottom:5px; padding:8px;" type="submit" value="Update" name="submit">
            <?php if (isset($errorMsg)) { ?>
              <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $errorMsg; ?>
              </div>
            <?php } ?>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->


  <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #D5AA36;margin-bottom: 0px;border-bottom-width: 0px;">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#" style="
    padding-bottom: 0px;
    padding-left: 0px;
    padding-top: 0px;
    padding-right: 0px;
    width: 50px;
"><img height="20" width="30" src="img/University_of_Pangasinan_logo.png" alt="" style="
    width: 50px;
    height: 50px;
"></a>
        <p class="navbar-text navbar-right">Scholarship Management System</p>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="bi bi-bell-fill"></i> Welcome <span class="text-success"><?php echo ucwords($_SESSION['NAME']); ?>
              </span> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="scholarshiprequest.php">Notification Center</a></li>
              <li><a href="profile.php">Profile</a></li>
              <li><a href="changepassword.php">Change Password</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div class="wrapper">
    <div class="sidebar">
      <a href="dashboardadmin.php"><i class="bi bi-mortarboard"></i> Dashboard</a>
      <a href="scholars.php"><i class="bi bi-mortarboard"></i> Scholars</a>
      <a href="scholarships.php"><i class="bi bi-mortarboard"></i> Scholarship</a>
      <a href="scholarshiprequest.php"><i class="bi bi-mortarboard"></i> Scholarship Request</a>
      <a href="announcement.php"><i class="bi bi-megaphone"></i> Announcement</a>
      <a href="feedback.php"><i class="bi bi-star"></i> Feedback</a>
      <a href="featured scholar.php"><i class="bi bi-mortarboard"></i> Featured Scholars</a>
      <a href="setings.php"><i class="bi bi-mortarboard"></i> Settings</a>
      <a href="useraccount.php"><i class="bi bi-person-plus"></i> User Accounts</a>
      <a href="userlogs.php"><i class="bi bi-mortarboard"></i> User Logs</a>
    </div>




    <div class="container-fluid" style="
    margin-top: 50px;
">
      <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <div class="form-group">
            <img src="img/avatar.png" height="100px" width="100px" />
          </div>
          <div class="form-group">
            <h1><?php echo $_SESSION['NAME']; ?></h1>
          </div>
          <div class="form-group">
            <h4><?php echo $_SESSION['USERNAME']; ?></h4>
          </div>
          <div class="form-group">
            <h4><?php echo $_SESSION['STUDENTNO']; ?></h4>
          </div>
          <div class="form-group">
            <h4><?php echo $_SESSION['COURSE']; ?></h4>
          </div>
          <div class="form-group">
            <h4><?php echo $_SESSION['CONTACTNO']; ?></h4>
          </div>
          <div class="form-group">
            <h4><?php echo $_SESSION['EMAILADDRESS']; ?></h4>
          </div>
          <div class="form-group">
            <!--<input type="submit" data-toggle="modal" data-target="#add" name="edit" class="btn btn-primary btn-block" value="Edit Profile">-->
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add">Edit Profile</button>
          </div>

        </form>
      </div>


      < </div>
    </div>







    <section>
      <!-- Footer -->
      <footer class="page-footer font-small blue" style="background-color: #617e3e; padding:5px;">
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2022 Copyright:
          <a style="color:#f2f2f2;" href="https://up.phinma.edu.ph/"> PHINMA University of pangasinan</a>
        </div>
        <!-- Copyright -->
      </footer>
      <!-- Footer -->
    </section>
</body>



</html>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Session Expiration</h4>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        Because you have been Inactivity, your session is about to expire.
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <a href="userlogin.php" class="btn btn-primary btn-sm">Login again</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  setInterval(check_user, 2000);

  function check_user() {
    $.ajax({
      url: 'checkuser.php',
      method: 'POST',
      data: 'type=logout',
      success: function(result) {
        if (result == "logout") {
          $("#myModal").modal({
            backdrop: 'static',
            keyboard: false,
          });
          setTimeout(function() {
            $('#myModal').modal('hide')
            window.location.href = "logout.php";
          }, 10000);
        }
      }
    });
  }
</script>