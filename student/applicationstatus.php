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


<?php

function get_all_records()
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname   = "dbscholarship";
    $con = new mysqli($hostname, $username, $password, $dbname);
    $Sql = "SELECT * FROM currentyear";
    $result = mysqli_query($con, $Sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $year = $row['year'];
        $semester = $row['semester'];
        $userid = $_SESSION['ID'];
        $studentno = $_SESSION['STUDENTNO'];
        $Sql = "SELECT * FROM scholarshiprequest WHERE (accountid = '$userid' OR studentno LIKE '$studentno')";
        $result = mysqli_query($con, $Sql);
        if (mysqli_num_rows($result) > 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['status'] == 'PENDING') {
                    echo '<div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">' . $row['type'] . ' FOR ' . $row['scholarship'] . '(' . $row['status'] . ')</h5>
                    <h6 class="card-title">' . $row['academicyear'] . ' ' . $row['semester'] . '</h6>
                    <p class="card-text"><small class="text-muted">' . $row['timestamp'] . '</small></p>
                    <button type="button" id="' . $row['id'] . '" class="btn btn-success viewform" > View Application Form </button>
                </div>
            </div>
        </div>';
                } else if ($row['status'] == 'APPROVED') {
                    echo '<div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">' . $row['type'] . ' FOR ' . $row['scholarship'] . '(' . $row['status'] . ')</h5>
                    <h6 class="card-title">' . $row['academicyear'] . ' ' . $row['semester'] . '</h6>
                    <p class="card-text"><small class="text-muted">' . $row['timestamp'] . '</small></p>
                    <button type="button" id="' . $row['id'] . '" class="btn btn-success viewform" > View Application Form </button>
                </div>
            </div>
        </div>';
                } else {
                    echo '<div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">' . $row['type'] . ' FOR ' . $row['scholarship'] . '(' . $row['status'] . ')</h5>
                    <h6 class="card-title">' . $row['academicyear'] . ' ' . $row['semester'] . '</h6>
                    <p class="card-text"><small class="text-muted">' . $row['timestamp'] . '</small></p>
                    <button type="button" id="' . $row['id'] . '" class="btn btn-success viewform" > View Application Form </button>
                </div>
            </div>
        </div>';
                }
            }
        } else if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['status'] == 'PENDING') {
                    echo '<div class="col">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">' . $row['type'] . ' FOR ' . $row['scholarship'] . '(' . $row['status'] . ')</h5>
                <h6 class="card-title">' . $row['academicyear'] . ' ' . $row['semester'] . '</h6>
                <p class="card-text"><small class="text-muted">' . $row['timestamp'] . '</small></p>
                <button type="button" id="' . $row['id'] . '" class="btn btn-success viewform" > View Application Form </button>
            </div>
        </div>
    </div>
    <div class="col">

    </div>';
                } else if ($row['status'] == 'APPROVED') {
                    echo '<div class="col">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">' . $row['type'] . ' FOR ' . $row['scholarship'] . '(' . $row['status'] . ')</h5>
                <h6 class="card-title">' . $row['academicyear'] . ' ' . $row['semester'] . '</h6>
                 <p class="card-text"><small class="text-muted">' . $row['timestamp'] . '</small></p>
                <button type="button" id="' . $row['id'] . '" class="btn btn-success viewform" > View Application Form </button>
            </div>
        </div>
    </div>
    <div class="col">

    </div>';
                } else {
                    echo '<div class="col">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">' . $row['type'] . ' FOR ' . $row['scholarship'] . '(' . $row['status'] . ')</h5>
                <h6 class="card-title">' . $row['academicyear'] . ' ' . $row['semester'] . '</h6>
                <p class="card-text"><small class="text-muted">' . $row['timestamp'] . '</small></p>
                <button type="button" id="' . $row['id'] . '" class="btn btn-success viewform" > View Application Form </button>
            </div>
        </div>
    </div>
    <div class="col">

    </div>';
                }
            }
        } else {
            echo '<div class="col">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">No Application </h5>
            </div>
        </div>
    </div>
    <div class="col">
    </div>';
        }
    } else {
        echo '<div class="col">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">No School Year Set</h5>
            </div>
        </div>
    </div>
    <div class="col">
    </div>';
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Application Status</title>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="background-color: D5AA36; padding:1px;">
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
                        <a class="nav-link" href="index.php">Home</a>
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
                                        echo '<li><a class="dropdown-item" href="applicationstatus.php">'.$result['notification'] . ' ' . $result['othernotif'] . '</a></li>';
                                        echo '<li><hr class="dropdown-divider"></li>';
                                    }else if($result['notifstatus'] == 3){
                                        echo '<li><a class="dropdown-item" href="applicationstatus.php">'.$result['othernotif'] . '</a></li>';
                                        echo '<li><hr class="dropdown-divider"></li>';
                                    }
                                    else{
                                        echo '<li><a class="dropdown-item" href="applicationstatus.php">'.$result['notification'] . '</a></li>';
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
    <div class="container-fluid" style="margin:50px 0px;">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php get_all_records() ?>
        </div><br>
        <div class="top-content">
            <style media="screen">
                img {
                    height: auto;
                    width: auto;
                }
            </style>
        </div>

    </div>


    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="scholarships.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Announcement </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="announcement_detail">

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="announcement.php" method="POST">
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

    <div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="announcement.php" method="POST">
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

    <div class="modal fade" id="profilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <form action="announcement.php" method="POST">
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
                <form action="announcement.php" method="POST">
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
            background: #617e3e;
            position: fixed;
        }

        a:link {
            color: #617e3e;
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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