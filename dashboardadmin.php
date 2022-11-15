<?php
include_once('checkuser.php');
?>

<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "dbscholarship";

// Create database connection
$con = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['changepassword'])) {
  $id = $_SESSION['ID'];
  $oldpassword = $con->real_escape_string($_POST['oldpassword']);
  $newpassword = $con->real_escape_string($_POST['newpassword']);
  $retypenewpassword = $con->real_escape_string($_POST['retypenewpassword']);
  $correctoldpass = $con->real_escape_string($_POST['correctoldpass']);

  if ($oldpassword == $correctoldpass) {
    if ($newpassword == $retypenewpassword) {
      $update = "UPDATE users SET password = '$newpassword' WHERE id = '$id' ";
      $result = $con->query($update);
      echo '<script> alert("Password Changed"); </script>';
    } else {
      echo '<script> alert("Incorrect Retype Password"); </script>';
    }
  } else {
    echo '<script> alert("Incorrect Old Password"); </script>';
  }
}

?>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');

if (isset($_POST['editprofile'])) {
  $id = $_SESSION['ID'];

  $fullname = mysqli_real_escape_string($connection, $_POST['name']);
  $address = mysqli_real_escape_string($connection, $_POST['address']);
  $emailaddress = mysqli_real_escape_string($connection, $_POST['emailaddress']);
  $contactno = mysqli_real_escape_string($connection, $_POST['contactno']);



  $query = "UPDATE users SET  name=UPPER('$fullname'), address=UPPER('$address'), emailaddress=UPPER('$emailaddress'), contactno=UPPER('$contactno') WHERE id='$id'  ";
  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    $_SESSION['NAME'] = $_POST['name'];
    echo '<script> alert("Profile Updated"); </script>';
  } else {
    echo '<script> alert("Profile Not Updated"); </script>';
  }
}
?>

<?php
$con  = mysqli_connect("localhost", "root", "", "dbscholarship");
if (!$con) {
  # code...

} else {
  $Sql = "SELECT * FROM currentyear";
  $result = mysqli_query($con, $Sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $year = $row['year'];
    $semester = $row['semester'];
    $sql = "SELECT course, COUNT(DISTINCT studentno) AS total FROM scholars WHERE academicyear = '$year' AND semester LIKE '$semester'  GROUP BY course";
    $result = mysqli_query($con, $sql);
    $chart_data = "";
    while ($row = mysqli_fetch_array($result)) {
      $productname[]  = $row['course'];
      $sales[] = $row['total'];
    }
  }
}
?>


<!doctype html>
<html lang="en">

<head>
  <title>Dashboard</title>
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
    background-color: #f1f1f1;
  }
  .sidenav a {
    display: block;
    color: black;
    padding: 13px;
    text-decoration: none;
  }

  .sidenav a.active {
    background-color: #04AA6D;
    color: white;
    margin-left: -15px;
    margin-right: -15px;
  }

  .sidenav a:hover:not(.active) {
    background-color: #04AA6D;
    color: white;
    margin-left: -15px;
    margin-right: -15px;
    opacity: .6;
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

  .icon a:link,
  .icon a:visited {
    background-color: #04AA6D;
    color: white;
    width: 100%;
    padding: 5%;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    display: block;
  }

  .icon a:hover,
  .icon a:active {
    opacity: .7;
  }

  .dropdown-container {
    display: none;
    background-color: #f1f1f1;
    padding-left: 1%;
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

    nav {
      max-height: 50vh;
      overflow: auto;
    }
  }

  @media screen and (max-width: 400px) {
    nav {
      max-height: 25vh;
      overflow: auto;
    }

    .sidebar a {
      text-align: left;
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
        <p class="navbar-text navbar-right">Scholarship Management System</p>
      </div>
      <?php
      $connection = mysqli_connect("localhost", "root", "");
      $db = mysqli_select_db($connection, 'dbscholarship');
      $Sql = "SELECT * FROM currentyear";
      $result = mysqli_query($con, $Sql);
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $year = $row['year'];
        $semester = $row['semester'];
        $query = "SELECT * FROM scholarshiprequest WHERE notifstatus=0 AND notiffor LIKE 'Admin' AND academicyear='$year' AND semester LIKE '$semester'";
        $query_run = mysqli_query($connection, $query);
        $count = mysqli_num_rows($query_run);
      }
      ?>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="bi bi-bell-fill"></i><span class="badge"><?php if(mysqli_num_rows($result) > 0) echo $count; ?></span>
            </a>
            <ul class="dropdown-menu">
              <?php
              if(mysqli_num_rows($result) > 0){
                $connection = mysqli_connect("localhost", "root", "");
              $db = mysqli_select_db($connection, 'dbscholarship');
              $query = "SELECT * FROM scholarshiprequest WHERE notifstatus=0 AND notiffor LIKE 'Admin' AND academicyear='$year' AND semester LIKE '$semester'";
              $query_run = mysqli_query($connection, $query);
              if (mysqli_num_rows($query_run) > 0) {
                while ($result = mysqli_fetch_assoc($query_run)) {
                  echo '<li><a href="scholarshiprequest.php">' . $result['notification'] . '</a></li>';
                  echo '<li role="separator" class="divider"></li>';
                }
              } else {
                echo '<li><a>No Notification</a></li>';
              }
              }else{
                echo '<li><a>No School Year Set</a></li>';
              }

              ?>

            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome <span class="text-success"><?php echo ucwords($_SESSION['NAME']); ?>
              </span> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="viewprofile" id=" <?php echo $_SESSION['ID']; ?>">Profile</a></li>
              <li><a class="changepassword" id=" <?php echo $_SESSION['ID']; ?>">Change Password</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>


  <div class="container-fluid" style="padding-top: 50px;">
    <div class="row">
      <div class="col-sm-2 sidenav">
        <a href="dashboardadmin.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="scholars.php"><i class="bi bi-person-check"></i> Scholars</a>
        <a href="scholarships.php"><i class="bi bi-mortarboard"></i> Scholarship</a>
        <a href="scholarshiprequest.php"><i class="bi bi-envelope"></i> Scholarship Request</a>
        <a href="exammanagement.php"><i class="bi bi-journal-text"></i> Exam Management</a>
        <a href="announcement.php"><i class="bi bi-megaphone"></i> Announcement</a>
        <a href="feedback.php"><i class="bi bi-star"></i> Feedback</a>
        <a href="featured scholar.php"><i class="bi bi-mortarboard"></i> Featured Scholars</a>
        <a href="setings.php"><i class="bi bi-gear"></i> Settings</a>
        <hr style="border:1px solid black;">
        <a class="dropdown-btn"><i class="bi bi-caret-down"></i>User Account</a>
        <div class="dropdown-container">
          <a href="useraccount.php"><i class="bi bi-mortarboard"></i> Student</a>
          <a href="useraccountadmin.php"><i class="bi bi-person"></i>Admin</a>
        </div>
        <a href="userlogs.php"><i class="bi bi-person-lines-fill"></i> User Logs</a>
      </div>

  <div id="page-content-wrapper">
                 <div class="col-sm-10">
                   <div class="row">
                     <div class="container-fluid">
                         <br>
                       <form style="background:#f1f1f1; " class="form-horizontal" action="dashboard.php" method="post" name="upload_excel" enctype="multipart/form-data">
                         <fieldset>
                           <!-- Form Name -->
                           <legend>Dashboard</legend>
                           <!-- File Button -->
                           <div class="row placeholders">
                             <div class="col-xs-12 col-sm-4 placeholder icon">
                               <?php
                               $con = mysqli_connect("localhost", "root", "");


                               mysqli_select_db($con, "dbscholarship");

                               $result = mysqli_query($con, "select count(*) FROM scholars");
                               $row = mysqli_fetch_array($result);

                               $total = $row[0];

                               mysqli_close($con);
                               ?>
                               <a href="scholars.php" target="_self"><i class="bi bi-person-check"></i> SCHOLARS: <?php echo $total ?></a>

                             </div>
                             <div class="col-xs-12 col-sm-4 placeholder icon">
                               <?php
                               $con = mysqli_connect("localhost", "root", "");


                               mysqli_select_db($con, "dbscholarship");

                               $result = mysqli_query($con, "select count(*) FROM scholarships");
                               $row = mysqli_fetch_array($result);

                               $total = $row[0];

                               mysqli_close($con);
                               ?>
                               <a href="scholarships.php" target="_self"><i class="bi bi-mortarboard"></i> SCHOLARSHIPS: <?php echo $total ?></a>

                             </div>
                             <div class="col-xs-12 col-sm-4 placeholder icon">
                               <?php
                               $con = mysqli_connect("localhost", "root", "");


                               mysqli_select_db($con, "dbscholarship");

                               $result = mysqli_query($con, "select count(*) FROM announcements");
                               $row = mysqli_fetch_array($result);

                               $total = $row[0];

                               mysqli_close($con);
                               ?>
                               <a href="announcement.php" target="_selfe"><i class="bi bi-megaphone"></i> ANNOUNCEMENTS: <?php echo $total ?></a>
                             </div>
                             <!-- Button -->
                         </fieldset>
                       </form>

                       <div style="width:100%;height:40%;text-align:center">
                         <h2 class="page-header">Scholars Report</h2>
                         <canvas id="chartjs_bar"></canvas>
                       </div>
                     </div>

                   </div>
                 </div>
                 </div>
         </div>
       </div>
  <script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });
    }
  </script>


  <div class="modal fade" id="profilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <form action="dashboardadmin.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Profile </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="form_profile">

          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
            <button type="submit" name="editprofile" class="btn btn-primary">Update Profile</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="passwordmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <form action="dashboardadmin.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Change Password </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="form_password">

          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
            <button type="submit" name="changepassword" class="btn btn-primary">Change Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
  <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript">
    var ctx = document.getElementById("chartjs_bar").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($productname); ?>,
        datasets: [{
          backgroundColor: [
            "#5969ff",
            "#ff407b",
            "#25d5f2",
            "#ffc750",
            "#2ec551",
            "#7040fa",
            "#ff004e"
          ],
          data: <?php echo json_encode($sales); ?>,
        }]
      },
      options: {
        legend: {
          display: false,
          position: 'bottom',

          labels: {
            fontColor: '#71748d',
            fontFamily: 'Circular Std Book',
            fontSize: 14,
          }
        },


      }
    });
  </script>

  <script>
    $(document).ready(function() {

      $('.viewprofile').on('click', function() {
        var id = $(this).attr("id");

        $.ajax({
          url: "viewprofile.php",
          method: "post",
          data: {
            id: id
          },
          success: function(data) {
            $('#form_profile').html(data);
            $('#profilemodal  ').modal('show');
          }
        })
      });
    });
  </script>

  <script>
    $(document).ready(function() {

      $('.changepassword').on('click', function() {
        var id = $(this).attr("id");

        $.ajax({
          url: "changepassword.php",
          method: "post",
          data: {
            id: id
          },
          success: function(data) {
            $('#form_password').html(data);
            $('#passwordmodal  ').modal('show');
          }
        })
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
        <h4 class="modal-title">Session Expired</h4>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        Because you have been Inactivity, your session expired.
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <a href="index.php" class="btn btn-primary btn-sm">Login again</a>
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
