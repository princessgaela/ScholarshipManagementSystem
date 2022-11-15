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
  $studentno = mysqli_real_escape_string($connection, $_POST['studentno']);
  $fullname = mysqli_real_escape_string($connection, $_POST['name']);
  $course = mysqli_real_escape_string($connection, $_POST['course']);
  $yearlevel = mysqli_real_escape_string($connection, $_POST['yearlevel']);
  $dateofbirth = mysqli_real_escape_string($connection, $_POST['dateofbirth']);
  $gender = mysqli_real_escape_string($connection, $_POST['gender']);
  $address = mysqli_real_escape_string($connection, $_POST['address']);
  $civilstatus = mysqli_real_escape_string($connection, $_POST['civilstatus']);
  $citizenship = mysqli_real_escape_string($connection, $_POST['citizenship']);
  $contactno = mysqli_real_escape_string($connection, $_POST['contactno']);
  $zipcode = mysqli_real_escape_string($connection, $_POST['zipcode']);
  $emailaddress = mysqli_real_escape_string($connection, $_POST['emailaddress']);
  $fatherstatus = mysqli_real_escape_string($connection, $_POST['fatherstatus']);
  $fathername = mysqli_real_escape_string($connection, $_POST['fathername']);
  $fatheroccupation = mysqli_real_escape_string($connection, $_POST['fatheroccupation']);
  $fathereducation = mysqli_real_escape_string($connection, $_POST['fathereducation']);
  $motherstatus = mysqli_real_escape_string($connection, $_POST['motherstatus']);
  $mothername = mysqli_real_escape_string($connection, $_POST['mothername']);
  $motheroccupation = mysqli_real_escape_string($connection, $_POST['motheroccupation']);
  $mothereducation = mysqli_real_escape_string($connection, $_POST['mothereducation']);
  $totalgrossincome = mysqli_real_escape_string($connection, $_POST['totalgrossincome']);
  $siblings = mysqli_real_escape_string($connection, $_POST['siblings']);




  $query = "UPDATE users SET  studentno=UPPER('$studentno'), name=UPPER('$fullname'), course=UPPER('$course'), yearlevel=UPPER('$yearlevel'), dateofbirth=UPPER('$dateofbirth'), gender=UPPER('$gender'), address=UPPER('$address'), civilstatus=UPPER('$civilstatus'), citizenship=UPPER('$citizenship'), contactno=UPPER('$contactno'), zipcode=UPPER('$zipcode'), emailaddress=UPPER('$emailaddress'), fatherstatus=UPPER('$fatherstatus'), fathername=UPPER('$fathername'), fatheroccupation=UPPER('$fatheroccupation'), fathereducation=UPPER('$fathereducation'), motherstatus=UPPER('$motherstatus'), mothername=UPPER('$mothername'), motheroccupation=UPPER('$motheroccupation'), mothereducation=UPPER('$mothereducation'), totalgrossincome=UPPER('$totalgrossincome'), siblings=UPPER('$siblings') WHERE id='$id'  ";
  $query_run = mysqli_query($connection, $query);


  if ($query_run) {
    $_SESSION['NAME'] = strtoupper($_POST['name']);
    echo '<script> alert("Profile Updated"); </script>';
  } else {
    echo '<script> alert("Data Not Updated"); </script>';
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Homepage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="shortcut icon" type="x-icon" href="img/University_of_Pangasinan_logo.png">
  <link rel="stylesheet" href="css\animate.css">
  <link rel="stylesheet" href="css\media-queries.css">
  <link rel="stylesheet" href="js\wow.js">
  <link rel="stylesheet" href="js\wow.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" />
</head>

<style>
  @media screen and (max-width: 700px) {


    nav {
      max-height: 40vh;
      overflow: auto;
    }
  }

  @media screen and (max-width: 400px) {
    nav {
      max-height: 40vh;
      overflow: auto;

    }
  }
</style>

<body>
  <nav style="border-bottom:  0.5px solid #6a8649; " class="navbar navbar-expand-lg navbar-light bg-light  fixed-top" style="background-color: D5AA36; padding:1px;">
    <div class="container-fluid">

      <a style=" color: f2f2f2;" class="navbar-brand">
        <img height="20" width="30" src="img/University_of_Pangasinan_logo.png" alt="" style="width: 50px;height: 50px;"> Scholarship Management System
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php
        $connection = mysqli_connect("localhost", "root", "");
        $db = mysqli_select_db($connection, 'dbscholarship');
        $accountid = $_SESSION['ID'];

        $query = "SELECT * FROM scholarshiprequest WHERE (notifstatus=1 OR notifstatus=3) AND accountid=$accountid";
        $query_run = mysqli_query($connection, $query);
        $count = mysqli_num_rows($query_run);
        ?>
        <ul class="navbar-nav  ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="scholarships.php">Scholarship</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="announcement.php">Announcement</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="notif" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-bell"></i><span class="badge bg-danger"><?php echo $count; ?></span></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <?php
              $connection = mysqli_connect("localhost", "root", "");
              $db = mysqli_select_db($connection, 'dbscholarship');
              $query = "SELECT * FROM scholarshiprequest WHERE (notifstatus=1 OR notifstatus=3) AND accountid=$accountid";
              $query_run = mysqli_query($connection, $query);
              if (mysqli_num_rows($query_run) > 0) {
                while ($result = mysqli_fetch_assoc($query_run)) {
                  if ($result['othernotif'] != '' && $result['notifstatus'] == 1) {
                    echo '<li><a class="dropdown-item" href="applicationstatus.php">' . $result['notification'] . ' ' . $result['othernotif'] . '</a></li>';
                    echo '<li><hr class="dropdown-divider"></li>';
                  } else if ($result['notifstatus'] == 3) {
                    echo '<li><a class="dropdown-item" href="applicationstatus.php">' . $result['othernotif'] . '</a></li>';
                    echo '<li><hr class="dropdown-divider"></li>';
                  } else {
                    echo '<li><a class="dropdown-item" href="applicationstatus.php">' . $result['notification'] . '</a></li>';
                    echo '<li><hr class="dropdown-divider"></li>';
                  }
                }
              } else {
                echo '<li><a>No Notification</a></li>';
              }

              ?>

            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Welcome <span class="text-success"><?php echo ucwords($_SESSION['NAME']); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item viewprofile" id=" <?php echo $_SESSION['ID']; ?>">Profile</a></li>
              <li><a class="dropdown-item" href="applicationstatus.php">Application Status</a></li>
              <li><a class="dropdown-item changepassword" id=" <?php echo $_SESSION['ID']; ?>">Change Password</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
            </ul>
          </li>
      </div>
    </div>
  </nav>

  <br><br>
  <div class="top-content">
    <style media="screen">
      img {
        height: auto;
        width: auto;
      }
    </style>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="ad\img(19).jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">

          </div>
        </div>
        <div class="carousel-item">
          <img src="ad\img(20).jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">

          </div>
        </div>
        <div class="carousel-item">
          <img src="ad\img(23).png" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">

          </div>
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>


  <br>


  <br>
  <!-- Top content-->


  <!-- Section 2 -->
  <div class="section-1-container section-container">
    <h1 class="text-center fw-bold mb-3"><span class="text-success">Featured Scholar</span></h1>
    <div class="container">
      <div class="row">
        <div class="col-md-4 section-1-box wow fadeInDown">
          <div class="col-md-9">
          </div>
        </div>
        <div class="card mb-3" style="margin-top: 1%; margin-bottom: 1%">
          <?php
          $hostname = "localhost";
          $username = "root";
          $password = "";
          $dbname   = "dbscholarship";
          $con = new mysqli($hostname, $username, $password, $dbname);
          $Sql = "SELECT * FROM featuredscholars WHERE status LIKE 'Featured'";
          $result = mysqli_query($con, $Sql);
          $row = mysqli_fetch_assoc($result);
          if (mysqli_num_rows($result) > 0) {
            echo "
              <div class='row mt-3'>

    <div class='col-md-8'>
      <div class='card-body'>
        <h5 class='card-title text-center'>" . $row['name'] . "</h5>
        <h6 class='card-subtitle text-center'>" . $row['course'] . " (" . $row['yeargraduated'] . ")</h6><hr>
        <p class='card-text text-center' style='white-space: pre-wrap;'>" . $row['message'] . "</p>
      </div>
    </div>
    <div class='col-md-4'>
      <img src='../image/" . $row['picture'] . "' class='img-fluid' alt='...' style='width: 100%;
      height: 15vw;
      object-fit: contain;'>
    </div>
  </div>";
          } else {
            echo "
              <div class='card-body'>
                <h5 class='card-title text-center'>No Featured Scholar Selected</h5>
              </div>";
          }
          ?>
        </div>
      </div>
      <div class="col-md-4 section-1-box wow fadeInUp">
        <div class="row">
          <div class="col-md-9">
          </div>
        </div>
      </div>
    </div>
  </div>


  <!--section3-->
  <br><br><br>
  <div style="background:#f5f5f5;" class="section-2-container section-container"><br>
    <h1 class="text-center fw-bold mb-3">PHINMA UPANG <span class="text-success">Scholarships</span></h1><br>
    <div class="container">
      <div class="row">
        <div class="col-13 m-auto">
          <div class="owl-carousel owl-theme">
            <?php
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $dbname   = "dbscholarship";
            $con = new mysqli($hostname, $username, $password, $dbname);
            $Sql = "SELECT * FROM scholarships";
            $result = mysqli_query($con, $Sql);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='item'>
              <div class='card'>
                <img src='../img/University_of_Pangasinan_logo.png' alt='' class='card-img-top'>
                <div class='card-body'>
                  <div class='card-title text-center'>
                    <h4>" . $row['name'] . "</h4>
                    <p class='card-text'>" . $row['briefdescription'] . "</p>
                    <a class='btn btn-success' href='scholarships.php'>See Scholarship</a>
                  </div>
                </div>
              </div>
            </div>";
              }
            } else {
              echo "<div class='item'>
              <div class='card'>
                <img src='../img/University_of_Pangasinan_logo.png' alt='' class='card-img-top'>
                <div class='card-body'>
                  <div class='card-title text-center'>
                    <h4>No Scholarship Available</h4>
                  </div>
                </div>
              </div>
            </div>";
            }
            ?>

          </div>
        </div>
      </div>
    </div><br><br>
  </div>
  <br><br><br><br>


  <!-- Section 4 -->
  <div class="section-1-container section-container">
    <div class="grid" style="--bs-columns: 3;">
      <div class="row">
        <div class="col-md-4 section-1-box wow fadeInDown">
          <div class="row">
            <div class="col-md-12 ">
              <h3 class="text-center">School Mission</h3>
              <p class="text-center">To develop the Filipino youth into employable global professionals thru the
                endownment of knowledge and skills and formation of character and spirit.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 section-1-box wow fadeInUp">
          <div class="row">
            <div class="col-md-12">
              <h3 class="text-center">Mission of the PHINMA Education Network</h3>
              <p class="text-center">Through the application of effective management in institution of higher and basic learning, to give Filipinos better
                access to affordable, high quality education in key cities throughout the Philippines, preparing them to be globally competitive</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 section-1-box wow fadeInUp">
          <div class="row">
            <div class="col-md-12">
              <h3 class="text-center">School Vision</h3>
              <p class="text-center">With distinct advantage in English Communication and Information Technology,
                to be the leading institution of higher learning in the region development of globally competitive professionals.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br><br><br>
  <div style="background:#f5f5f5; padding-top:50px;padding-bottom:50px;" class="section-4-container section-container">
    <div class="row">
      <div class="col-md-12 ">
        <h3 class="text-center">Choose PHINMA Education</h3>
        <p class="text-center">As an innovative Philippine business institution, PHINMA believes that access to quality education is the solution to many of our country’s problems. While the enrollment rate in the Philippines has always been high, PHINMA discovered that most students do not finish tertiary education. Students were willing to learn but did not have the resources to stay in school.
          That is why in 2004, PHINMA Education was established. PHINMA Education is making education accessible in key growth areas all over the country. It has transformed existing educational institutions to provide better academic, operational, and community support for all of its students. Through its efforts more students are able to earn college degrees and become globally competitive professionals.
          The PHINMA Education Network is now composed of six secondary and tertiary educational institutions spread throughout the country</p>
      </div>
    </div>
  </div>




  </div>
  <div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <form action="index.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Application Form </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="form_detail">

          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal hide" id="profilemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <form action="index.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Profile </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="form_profile">

          </div>
          <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
            <button type="submit" name="editprofile" class="btn btn-primary">Update Profile</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="passwordmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <form action="index.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Change Password </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="form_password">

          </div>
          <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
            <button type="submit" name="changepassword" class="btn btn-primary">Change Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>








  <style>
    footer {
      background: #6a8649;
      height: 188px;
    }

    a:link {
      color: #fff;
      text-decoration: none;
    }

    a {
      color: #fff;
      text-decoration: none;
    }

    a:hover {
      color: #D5AA36;
      text-decoration: none;
    }

    a:active {
      color: #fff;
      text-decoration: none;

    }
  </style>
  <!-- Footer -->
  <footer>
    <div class="container" style="padding: 70px 0;" align="center">
      <a href="https://www.facebook.com/UPangPHINMA">
        <i class="bi bi-facebook fa-lg white-text mr-md-5 mr-5 fa-3x"></i>
        UPangPHINMA
      </a>
      <a href="https://twitter.com/phinmaupang?lang=en">
        <i class="bi bi-twitter fa-lg white-text mr-md-5 mr-5 fa-3x"></i>
        @phinmaupang
      </a>
      <a href="https://www.instagram.com/phinmaupang/?hl=en">
        <i class="bi bi-instagram fa-lg white-text mr-md-5 mr-5 fa-3x"></i>
        phinmaupang
      </a>
      <a href="#">
        <i class="bi bi-youtube fa-lg white-text mr-md-5 mr-5 fa-3x"></i>
        PHINMA UPANG
      </a>

    </div>
    <div style="background: #617e3e;">
      <p style="color: #f2f2f2; padding: 15px 0; font-size:13px;" align="center">
        &copy; 2022 Copyright: <a href="https://up.phinma.edu.ph/">PHINMA University of pangasinan</a>
      </p>
    </div>
  </footer>





</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>
<script>
  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 15,
    nav: true,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 2
      },
      1000: {
        items: 4
      }
    }
  })
</script>
<script>
  $(document).ready(function() {

    $('.viewform').on('click', function() {
      var id = $(this).attr("id");

      $.ajax({
        url: "viewapplicationform.php",
        method: "post",
        data: {
          id: id
        },
        success: function(data) {
          $('#form_detail').html(data);
          $('#formmodal').modal('show');
        }

      })



    });
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
        url: "changepasswordstudent.php",
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
        <a href="../index.php" class="btn btn-primary btn-sm">Login again</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  setInterval(check_user, 2000);

  function check_user() {
    $.ajax({
      url: '../checkuser.php',
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
            window.location.href = "../logout.php";
          }, 10000);
        }
      }
    });
  }
</script>