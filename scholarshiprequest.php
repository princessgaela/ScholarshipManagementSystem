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

$conn = mysqli_connect('localhost', 'root', '', 'dbscholarship');

if (isset($_GET['file_id'])) {
  $id = $_GET['file_id'];

  // fetch file to download from database
  $sql = "SELECT * FROM scholarshiprequest WHERE id=$id";
  $result = mysqli_query($conn, $sql);

  $file = mysqli_fetch_assoc($result);
  $filepath = 'student/requirements/' . $file['requirements'];

  if (file_exists($filepath)) {
    ob_clean();
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($filepath));
    header('Expires: 10');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    ob_clean();
    flush();
    readfile('student/requirements/' . $file['requirements']);
    exit;
  }
}

?>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');

if (isset($_POST['rapprove'])) {
  $Sql = "SELECT * FROM currentyear";
  $result = mysqli_query($connection, $Sql);
  $row = mysqli_fetch_assoc($result);
  $year = $row['year'];
  $semester = $row['semester'];
  extract($_POST);
  $id = mysqli_real_escape_string($connection, $_POST['renew_id']);
  $studentno = mysqli_real_escape_string($connection, $_POST['renew_studentno']);
  $name = mysqli_real_escape_string($connection, $_POST['renew_name']);
  $course = mysqli_real_escape_string($connection, $_POST['renew_course']);
  $yearlevel = mysqli_real_escape_string($connection, $_POST['renew_yearlevel']);
  $scholarship = mysqli_real_escape_string($connection, $_POST['renew_scholarship']);
  $accountid = mysqli_real_escape_string($connection, $_POST['renew_accountid']);

  $description =  $studentno . " Scholarship renewal request has been approved";
  $author = $_SESSION['NAME'];
  $query = "UPDATE scholarshiprequest SET status='APPROVED',notification='Your scholarship renewal request for " . $scholarship . " has been approved!',notifstatus=1,notiffor='$studentno' WHERE id='$id'  ";
  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    $query = "INSERT INTO userlogs (`description`,`author`) VALUES ('$description','$author')";
    $query_run = mysqli_query($connection, $query);
    $query = "SELECT * FROM scholars WHERE studentno LIKE '$studentno' AND scholarship LIKE'$scholarship' AND academicyear='$year' AND semester LIKE '$semester'";
    $query_run = mysqli_query($connection, $query);
    if (mysqli_num_rows($query_run) > 0) {
      $row = mysqli_fetch_assoc($query_run);
      $updateid = $row['id'];
    } else {
      $query = "INSERT INTO scholars (`studentno`,`name`,`course`,`yearlevel`,`scholarship`,`accountid`,`academicyear`,`semester`) VALUES (UPPER('$studentno'),UPPER('$name'),UPPER('$course'),UPPER('$yearlevel'),UPPER('$scholarship'),'$accountid','$year','$semester')";
      $query_run = mysqli_query($connection, $query);
    }
    echo '<script> alert("Scholarship Renewal Request Approved"); </script>';
  } else {
    echo '<script> alert("Error"); </script>';
  }
}
?>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');


if (isset($_POST['rdecline'])) {
  $Sql = "SELECT * FROM currentyear";
  $result = mysqli_query($connection, $Sql);
  $row = mysqli_fetch_assoc($result);
  $year = $row['year'];
  $semester = $row['semester'];
  extract($_POST);
  $id = mysqli_real_escape_string($connection, $_POST['renew_id']);
  $studentno = mysqli_real_escape_string($connection, $_POST['renew_studentno']);
  $scholarship = mysqli_real_escape_string($connection, $_POST['renew_scholarship']);

  $description =  $studentno . " Scholarship renewal request has been declined";
  $author = $_SESSION['NAME'];
  $query = "UPDATE scholarshiprequest SET status='DECLINED',notification='Your scholarship renewal request for " . $scholarship . " has been declined!',notifstatus=1,notiffor='$studentno' WHERE id='$id'  ";
  $query_run = mysqli_query($connection, $query);


  if ($query_run) {
    $query = "INSERT INTO userlogs (`description`,`author`) VALUES ('$description','$author')";
    $query_run = mysqli_query($connection, $query);
    $query = "SELECT * FROM scholars WHERE studentno LIKE '$studentno' AND scholarship LIKE'$scholarship' AND academicyear='$year' AND semester LIKE '$semester'";
    $query_run = mysqli_query($connection, $query);
    if (mysqli_num_rows($query_run) > 0) {
      $row = mysqli_fetch_assoc($query_run);
      $updateid = $row['id'];
      $query = "DELETE FROM scholars WHERE id='$updateid'";
      $query_run = mysqli_query($connection, $query);
    } else {
    }
    echo '<script> alert("Scholarship Renewal Request Declined"); </script>';
  } else {
    echo '<script> alert("Error"); </script>';
  }
}
?>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');

if (isset($_POST['approve'])) {
  $Sql = "SELECT * FROM currentyear";
  $result = mysqli_query($connection, $Sql);
  $row = mysqli_fetch_assoc($result);
  $year = $row['year'];
  $semester = $row['semester'];
  extract($_POST);
  $id = mysqli_real_escape_string($connection, $_POST['update_id']);
  $studentno = mysqli_real_escape_string($connection, $_POST['update_studentno']);
  $name = mysqli_real_escape_string($connection, $_POST['update_name']);
  $course = mysqli_real_escape_string($connection, $_POST['update_course']);
  $yearlevel = mysqli_real_escape_string($connection, $_POST['update_yearlevel']);
  $scholarship = mysqli_real_escape_string($connection, $_POST['update_scholarship']);
  $accountid = mysqli_real_escape_string($connection, $_POST['update_accountid']);

  $description =  $studentno . " Scholarship application request has been approved";
  $author = $_SESSION['NAME'];
  $query = "UPDATE scholarshiprequest SET status='APPROVED',notification='Your scholarship application request for " . $scholarship . " has been approved!',notifstatus=1,notiffor='$studentno' WHERE id='$id'  ";
  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    $query = "INSERT INTO userlogs (`description`,`author`) VALUES ('$description','$author')";
    $query_run = mysqli_query($connection, $query);
    $query = "SELECT * FROM scholars WHERE studentno LIKE '$studentno' AND scholarship LIKE'$scholarship' AND academicyear='$year' AND semester LIKE '$semester'";
    $query_run = mysqli_query($connection, $query);
    if (mysqli_num_rows($query_run) > 0) {
      $row = mysqli_fetch_assoc($query_run);
      $updateid = $row['id'];
    } else {
      $query = "INSERT INTO scholars (`studentno`,`name`,`course`,`yearlevel`,`scholarship`,`accountid`,`academicyear`,`semester`) VALUES (UPPER('$studentno'),UPPER('$name'),UPPER('$course'),UPPER('$yearlevel'),UPPER('$scholarship'),'$accountid','$year','$semester')";
      $query_run = mysqli_query($connection, $query);
    }
    echo '<script> alert("Scholarship Application Request Approved"); </script>';
  } else {
    echo '<script> alert("Error"); </script>';
  }
}
?>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');


if (isset($_POST['decline'])) {
  $Sql = "SELECT * FROM currentyear";
  $result = mysqli_query($connection, $Sql);
  $row = mysqli_fetch_assoc($result);
  $year = $row['year'];
  $semester = $row['semester'];
  extract($_POST);
  $id = mysqli_real_escape_string($connection, $_POST['update_id']);
  $studentno = mysqli_real_escape_string($connection, $_POST['update_studentno']);
  $scholarship = mysqli_real_escape_string($connection, $_POST['update_scholarship']);

  $description =  $studentno . " Scholarship application request has been declined";
  $author = $_SESSION['NAME'];
  $query = "UPDATE scholarshiprequest SET status='DECLINED',notification='Your scholarship application request for " . $scholarship . " has been declined!',notifstatus=1,notiffor='$studentno' WHERE id='$id'  ";
  $query_run = mysqli_query($connection, $query);


  if ($query_run) {
    $query = "INSERT INTO userlogs (`description`,`author`) VALUES ('$description','$author')";
    $query_run = mysqli_query($connection, $query);
    $query = "SELECT * FROM scholars WHERE studentno LIKE '$studentno' AND scholarship LIKE'$scholarship' AND academicyear='$year' AND semester LIKE '$semester'";
    $query_run = mysqli_query($connection, $query);
    if (mysqli_num_rows($query_run) > 0) {
      $row = mysqli_fetch_assoc($query_run);
      $updateid = $row['id'];
      $query = "DELETE FROM scholars WHERE id='$updateid'";
      $query_run = mysqli_query($connection, $query);
    } else {
    }
    echo '<script> alert("Scholarship Application Request Declined"); </script>';
  } else {
    echo '<script> alert("Error"); </script>';
  }
}
?>
<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');

$sqledit = "SELECT * FROM `scholarships`";
$all_scholarshipsedit = mysqli_query($connection, $sqledit);

if (isset($_POST['change'])) {
  $id = $_POST['change_id'];
  $change_scholarship = mysqli_real_escape_string($connection, $_POST['change_scholarship']);
  $change_studentno = mysqli_real_escape_string($connection, $_POST['change_studentno']);
  $scholarship = mysqli_real_escape_string($connection, $_POST['scholarship']);
  $Sql = "SELECT * FROM currentyear";
  $result = mysqli_query($connection, $Sql);
  $row = mysqli_fetch_assoc($result);
  $year = $row['year'];
  $semester = $row['semester'];
  $description =  "Scholarship info of scholar has been updated";
  $author = $_SESSION['NAME'];
  $notification = 'Your scholarship has been change to ' . $scholarship . '!';

  $querys = "SELECT * FROM scholarshiprequest WHERE id='$id'";
  $query_runs = mysqli_query($connection, $querys);
  if (mysqli_num_rows($query_runs) > 0) {
    $result = mysqli_fetch_assoc($query_runs);
    if ($result['notifstatus'] == 2 || $result['notifstatus'] == 0) {
      $query = "UPDATE scholarshiprequest SET scholarship=UPPER('$scholarship'), othernotif='$notification', notifstatus=3  WHERE id='$id'";
      $query_run = mysqli_query($connection, $query);
    }else if($result['notifstatus'] == 1){
      $query = "UPDATE scholarshiprequest SET scholarship=UPPER('$scholarship'), othernotif='$notification', notifstatus=1  WHERE id='$id'";
      $query_run = mysqli_query($connection, $query);
    }else if($result['notifstatus'] == 3){
      $query = "UPDATE scholarshiprequest SET scholarship=UPPER('$scholarship'), othernotif='$notification', notifstatus=3  WHERE id='$id'";
      $query_run = mysqli_query($connection, $query);
    }
  }
  if ($query_run) {
    $query = "SELECT * FROM scholars WHERE studentno LIKE '$change_studentno' AND scholarship LIKE'$change_scholarship' AND academicyear='$year' AND semester LIKE '$semester'";
    $query_run = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_run) > 0) {
      $row = mysqli_fetch_assoc($query_run);
      $updateid = $row['id'];
      $query = "UPDATE scholars SET  scholarship=UPPER('$scholarship') WHERE id='$updateid'";
      $query_run = mysqli_query($connection, $query);
    } 
    $query = "INSERT INTO userlogs (`description`,`author`) VALUES ('$description','$author')";
    $query_run = mysqli_query($connection, $query);
    echo '<script> alert("Scholarship Updated"); </script>';
  } else {
    echo '<script> alert("Scholarship Not Updated"); </script>';
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
    $Sql = "SELECT * FROM scholarshiprequest WHERE academicyear = '$year' AND semester LIKE '$semester'";
    $result = mysqli_query($con, $Sql);
    if (mysqli_num_rows($result) > 0) {
      echo "<div id='tablediv' class='table-responsive table-hover'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr><th  style='display:none;'>ID</th>
                          <th>Type</th>
                          <th>Scholarship</th>
                          <th>Student No.</th>
                          <th>Name</th>
                          <th>Course</th>
                          <th>Year Level</th>
                          <th style='display:none;'>Academic Year</th>
                          <th style='display:none;'>Semester</th>
                          <th style='display:none;'>Date of Birth</th>
                          <th style='display:none;'>Gender</th>
                          <th style='display:none;'>Address</th>
                          <th style='display:none;'>Civil Status</th>
                          <th style='display:none;'>Citizenship</th>
                          <th style='display:none;'>Contact No.</th>
                          <th style='display:none;'>Zip Code</th>
                          <th style='display:none;'>Email</th>
                          <th style='display:none;'>Father Status</th>
                          <th style='display:none;'>Father Name</th>
                          <th style='display:none;'>Father Occupation</th>
                          <th style='display:none;'>Father Education</th>
                          <th style='display:none;'>Mother Status</th>
                          <th style='display:none;'>Mother Name</th>
                          <th style='display:none;'>Mother Occupation</th>
                          <th style='display:none;'>Mother Education</th>
                          <th style='display:none;'>Total Gross Income</th>
                          <th style='display:none;'>Siblings</th>
                          <th style='display:none;'>Status</th>
                          <th style='display:none;'>Account ID</th>
                          <th style='display:none;'>Exam Score</th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr></thead><tbody>";
      while ($row = mysqli_fetch_assoc($result)) {
        if ($row['type'] == 'RENEWAL') {
          echo "<tr><td  style='display:none;'>" . $row['id'] . "</td>
                   <td>" . $row['type'] . "</td>
                   <td>" . $row['scholarship'] . "</td>
                   <td>" . $row['studentno'] . "</td>
                   <td>" . $row['name'] . "</td>
                   <td>" . $row['course'] . "</td>
                   <td>" . $row['yearlevel'] . "</td>
                   <td style='display:none;'>" . $row['academicyear'] . "</td>
                   <td style='display:none;'>" . $row['semester'] . "</td>
                   <td style='display:none;'>" . $row['dateofbirth'] . "</td>
                   <td style='display:none;'>" . $row['gender'] . "</td>
                   <td style='display:none;'>" . $row['address'] . "</td>
                   <td style='display:none;'>" . $row['civilstatus'] . "</td>
                   <td style='display:none;'>" . $row['citizenship'] . "</td>
                   <td style='display:none;'>" . $row['contactno'] . "</td>
                   <td style='display:none;'>" . $row['zipcode'] . "</td>
                   <td style='display:none;'>" . $row['email'] . "</td>
                   <td style='display:none;'>" . $row['fatherstatus'] . "</td>
                   <td style='display:none;'>" . $row['fathername'] . "</td>
                   <td style='display:none;'>" . $row['fatheroccupation'] . "</td>
                   <td style='display:none;'>" . $row['fathereducation'] . "</td>
                   <td style='display:none;'>" . $row['motherstatus'] . "</td>
                   <td style='display:none;'>" . $row['mothername'] . "</td>
                   <td style='display:none;'>" . $row['motheroccupation'] . "</td>
                   <td style='display:none;'>" . $row['mothereducation'] . "</td>
                   <td style='display:none;'>" . $row['totalgrossincome'] . "</td>
                   <td style='display:none;'>" . $row['siblings'] . "</td>
                   <td style='display:none;'>" . $row['status'] . "</td>
                   <td style='display:none;'>" . $row['accountid'] . "</td>
                   <td style='display:none;'>" . $row['examscore'] . "</td>
                   <td><a  href='scholarshiprequest.php?file_id=" . $row['id'] . "'>Download Attachment</a></td>
                   <td><button type='button' class='btn btn-success renewbtn'> View Renewal Form  </button></td>
                   <td><button type='button' class='btn btn-primary changebtn'> Change Scholarship  </button></td>";
        } else {
          echo "<tr><td  style='display:none;'>" . $row['id'] . "</td>
                   <td>" . $row['type'] . "</td>
                   <td>" . $row['scholarship'] . "</td>
                   <td>" . $row['studentno'] . "</td>
                   <td>" . $row['name'] . "</td>
                   <td>" . $row['course'] . "</td>
                   <td>" . $row['yearlevel'] . "</td>
                   <td style='display:none;'>" . $row['academicyear'] . "</td>
                   <td style='display:none;'>" . $row['semester'] . "</td>
                   <td style='display:none;'>" . $row['dateofbirth'] . "</td>
                   <td style='display:none;'>" . $row['gender'] . "</td>
                   <td style='display:none;'>" . $row['address'] . "</td>
                   <td style='display:none;'>" . $row['civilstatus'] . "</td>
                   <td style='display:none;'>" . $row['citizenship'] . "</td>
                   <td style='display:none;'>" . $row['contactno'] . "</td>
                   <td style='display:none;'>" . $row['zipcode'] . "</td>
                   <td style='display:none;'>" . $row['email'] . "</td>
                   <td style='display:none;'>" . $row['fatherstatus'] . "</td>
                   <td style='display:none;'>" . $row['fathername'] . "</td>
                   <td style='display:none;'>" . $row['fatheroccupation'] . "</td>
                   <td style='display:none;'>" . $row['fathereducation'] . "</td>
                   <td style='display:none;'>" . $row['motherstatus'] . "</td>
                   <td style='display:none;'>" . $row['mothername'] . "</td>
                   <td style='display:none;'>" . $row['motheroccupation'] . "</td>
                   <td style='display:none;'>" . $row['mothereducation'] . "</td>
                   <td style='display:none;'>" . $row['totalgrossincome'] . "</td>
                   <td style='display:none;'>" . $row['siblings'] . "</td>
                   <td style='display:none;'>" . $row['status'] . "</td>
                   <td style='display:none;'>" . $row['accountid'] . "</td>
                   <td style='display:none;'>" . $row['examscore'] . "</td>
                   <td></td>
                   <td><button type='button' class='btn btn-success editbtn'> View Application Form  </button>
                   <td><button type='button' class='btn btn-primary changebtn'> Change Scholarship  </button></td>";
        }
      }
      echo "</tbody></table></div>";
    } else {
      echo "<div id='tablediv' class='table table-responsive table-hover'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr><th  style='display:none;'>ID</th>
                          <th>Type</th>
                          <th>Scholarship</th>
                          <th>Student No.</th>
                          <th>Name</th>
                          <th>Course</th>
                          <th>Year Level</th>
                          <th style='display:none;'>Academic Year</th>
                          <th style='display:none;'>Semester</th>
                          <th style='display:none;'>Date of Birth</th>
                          <th style='display:none;'>Gender</th>
                          <th style='display:none;'>Address</th>
                          <th style='display:none;'>Civil Status</th>
                          <th style='display:none;'>Citizenship</th>
                          <th style='display:none;'>Contact No.</th>
                          <th style='display:none;'>Zip Code</th>
                          <th style='display:none;'>Email</th>
                          <th style='display:none;'>Father Status</th>
                          <th style='display:none;'>Father Name</th>
                          <th style='display:none;'>Father Occupation</th>
                          <th style='display:none;'>Father Education</th>
                          <th style='display:none;'>Mother Status</th>
                          <th style='display:none;'>Mother Name</th>
                          <th style='display:none;'>Mother Occupation</th>
                          <th style='display:none;'>Mother Education</th>
                          <th style='display:none;'>Total Gross Income</th>
                          <th style='display:none;'>Siblings</th>
                          <th style='display:none;'>Status</th>
                          <th style='display:none;'>Account ID</th>
                          <th style='display:none;'>Exam Score</th>
                          <th></th>
                        </tr></thead><tbody>";
    }
  } else {
    echo "No School Year Set";
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Scholarship Request</title>
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

  .renewbtn {
    margin: auto;
    display: block;
  }

  .deletebtn {
    margin: auto;
    display: block;
  }

  .changebtn {
    margin: auto;
    display: block;
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
              <i class="bi bi-bell-fill"></i><span class="badge"><?php if (mysqli_num_rows($result) > 0) echo $count; ?></span>
            </a>
            <ul class="dropdown-menu">
              <?php
              if (mysqli_num_rows($result) > 0) {
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
              } else {
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
      </div>
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container-fluid" style="padding-top: 50px;">
    <div class="row">
      <div class="col-sm-2 sidenav">
        <a href="dashboardadmin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="scholars.php"><i class="bi bi-person-check"></i> Scholars</a>
        <a href="scholarships.php"><i class="bi bi-mortarboard"></i> Scholarship</a>
        <a href="scholarshiprequest.php" class="active"><i class="bi bi-envelope"></i> Scholarship Request</a>
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

      <br>
      <div class="col-sm-10">
        <div class="container-fluid">
          <form style="background:#f1f1f1;" class="form-horizontal" action="scholarshiprequest.php" method="post" name="upload_excel" enctype="multipart/form-data">
            <fieldset>
              <!-- Form Name -->
              <legend>Scholarship Request</legend>
              <!-- File Button -->
              <!-- Button -->
            </fieldset>
          </form>
        </div>
        <br>
        <?php
        get_all_records();
        ?>
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
        <form action="scholarshiprequest.php" method="POST">
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
        <form action="scholarshiprequest.php" method="POST">
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

  <div class="modal fade" id="renewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">


        <form action="scholarshiprequest.php" method="POST">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Scholarship Request Form </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <input type="hidden" name="renew_id" id="renew_id">
            <input type="hidden" name="renew_studentno" id="renew_studentno">
            <input type="hidden" name="renew_scholarship" id="renew_scholarship">
            <input type="hidden" name="renew_name" id="renew_name">
            <input type="hidden" name="renew_course" id="renew_course">
            <input type="hidden" name="renew_yearlevel" id="renew_yearlevel">
            <input type="hidden" name="renew_accountid" id="renew_accountid">
            <div class="form-group">
              <label> Type </label>
              <input readonly type="text" id="rtype" name="type" class="form-control">
            </div>

            <div class="form-group">
              <label> Scholarship </label>
              <input readonly type="text" id="rscholarship" name="scholarship" class="form-control"">
            </div>

            <div class=" form-group">
              <label> Student No. </label>
              <input readonly type="text" id="rstudentno" name="studentno" class="form-control">
            </div>

            <div class="form-group">
              <label> Name </label>
              <input readonly type="text" id="rname" name="name" class="form-control">
            </div>

            <div class="form-group">
              <label> Course </label>
              <input readonly type="text" id="rcourse" name="course" class="form-control">
            </div>

            <div class="form-group">
              <label> Year Level </label>
              <input readonly type="text" id="ryearlevel" name="yearlevel" class="form-control">
            </div>

            <div class="form-group">
              <label> Academic Year </label>
              <input readonly type="text" id="racademicyear" name="academicyear" class="form-control">
            </div>

            <div class="form-group">
              <label> Semester </label>
              <input readonly type="text" id="rsemester" name="semester" class="form-control">
            </div>
            <div class="form-group">
              <label> Contact No. </label>
              <input readonly type="text" id="rcontactno" name="contactno" class="form-control">
            </div>

            <div class="form-group">
              <label> Status </label>
              <input readonly type="text" id="rstatus" name="status" class="form-control">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="rdecline" class="btn btn-secondary">Decline</button>
        <button type="submit" name="rapprove" class="btn btn-primary">Approve</button>
      </div>
      </form>

    </div>
  </div>

  <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
  <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">


        <form action="scholarshiprequest.php" method="POST">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Scholarship Request Form </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <input type="hidden" name="update_id" id="update_id">
            <input type="hidden" name="update_studentno" id="update_studentno">
            <input type="hidden" name="update_scholarship" id="update_scholarship">
            <input type="hidden" name="update_name" id="update_name">
            <input type="hidden" name="update_course" id="update_course">
            <input type="hidden" name="update_yearlevel" id="update_yearlevel">
            <input type="hidden" name="update_accountid" id="update_accountid">
            <div class="form-group">
              <label> Exam Score </label>
              <input readonly type="text" id="score" name="score" class="form-control">
            </div>
            <div class="form-group">
              <label> Type </label>
              <input readonly type="text" id="type" name="type" class="form-control">
            </div>

            <div class="form-group">
              <label> Scholarship </label>
              <input readonly type="text" id="scholarship" name="scholarship" class="form-control"">
            </div>

            <div class=" form-group">
              <label> Student No. </label>
              <input readonly type="text" id="studentno" name="studentno" class="form-control">
            </div>

            <div class="form-group">
              <label> Name </label>
              <input readonly type="text" id="name" name="name" class="form-control">
            </div>

            <div class="form-group">
              <label> Course </label>
              <input readonly type="text" id="course" name="course" class="form-control">
            </div>

            <div class="form-group">
              <label> Year Level </label>
              <input readonly type="text" id="yearlevel" name="yearlevel" class="form-control">
            </div>

            <div class="form-group">
              <label> Academic Year </label>
              <input readonly type="text" id="academicyear" name="academicyear" class="form-control">
            </div>

            <div class="form-group">
              <label> Semester </label>
              <input readonly type="text" id="semester" name="semester" class="form-control">
            </div>

            <div class="form-group">
              <label> Date Of Birth </label>
              <input readonly type="text" id="dateofbirth" name="dateofbirth" class="form-control">
            </div>

            <div class="form-group">
              <label> Gender </label>
              <input readonly type="text" id="gender" name="gender" class="form-control">
            </div>

            <div class="form-group">
              <label> Address </label>
              <input readonly type="text" id="address" name="address" class="form-control">
            </div>

            <div class="form-group">
              <label> Civil Status </label>
              <input readonly type="text" id="civilstatus" name="civilstatus" class="form-control">
            </div>

            <div class="form-group">
              <label> Citizenship </label>
              <input readonly type="text" id="citizenship" name="citizenship" class="form-control">
            </div>

            <div class="form-group">
              <label> Contact No. </label>
              <input readonly type="text" id="contactno" name="contactno" class="form-control">
            </div>

            <div class="form-group">
              <label> Zip Code </label>
              <input readonly type="text" id="zipcode" name="zipcode" class="form-control">
            </div>

            <div class="form-group">
              <label> Email </label>
              <input readonly type="text" id="email" name="email" class="form-control">
            </div>

            <div class="form-group">
              <label> Father Status </label>
              <input readonly type="text" id="fatherstatus" name="fatherstatus" class="form-control">
            </div>

            <div class="form-group">
              <label> Father Name </label>
              <input readonly type="text" id="fathername" name="fathername" class="form-control">
            </div>

            <div class="form-group">
              <label> Father Occupation </label>
              <input readonly type="text" id="fatheroccupation" name="fatheroccupation" class="form-control">
            </div>

            <div class="form-group">
              <label> Father Education </label>
              <input readonly type="text" id="fathereducation" name="fathereducation" class="form-control">
            </div>

            <div class="form-group">
              <label> Mother Status </label>
              <input readonly type="text" id="motherstatus" name="motherstatus" class="form-control">
            </div>

            <div class="form-group">
              <label> Mother Name </label>
              <input readonly type="text" id="mothername" name="mothername" class="form-control">
            </div>

            <div class="form-group">
              <label> Mother Occupation </label>
              <input readonly type="text" id="motheroccupation" name="motheroccupation" class="form-control">
            </div>

            <div class="form-group">
              <label> Mother Education </label>
              <input readonly type="text" id="mothereducation" name="mothereducation" class="form-control">
            </div>

            <div class="form-group">
              <label> Total Gross Income </label>
              <input readonly type="text" id="totalgrossincome" name="totalgrossincome" class="form-control">
            </div>

            <div class="form-group">
              <label> Siblings </label>
              <input readonly type="text" id="siblings" name="siblings" class="form-control">
            </div>

            <div class="form-group">
              <label> Status </label>
              <input readonly type="text" id="status" name="status" class="form-control">
            </div>


          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="decline" class="btn btn-secondary">Decline</button>
        <button type="submit" name="approve" class="btn btn-primary">Approve</button>
      </div>
      </form>

    </div>
  </div>

  <div class="modal fade" id="changemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">


        <form action="scholarshiprequest.php" method="POST">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Change Scholarship </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <input type="hidden" name="change_id" id="change_id">
            <input type="hidden" name="change_studentno" id="change_studentno">
            <input type="hidden" name="change_scholarship" id="change_scholarship">
            <div class="form-group">
              <label> Scholarship </label>
              <select required id="scholarship" name="scholarship" class="form-control">
                <option></option>
                <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($scholarshipedit = mysqli_fetch_array(
                  $all_scholarshipsedit,
                  MYSQLI_ASSOC
                )) :;
                ?>
                  <option value="<?php echo $scholarshipedit["name"];
                                  // The value we usually set is the primary key
                                  ?>">
                    <?php echo $scholarshipedit["name"];
                    // To show the category name to the user
                    ?>
                  </option>
                <?php
                endwhile;
                // While loop must be terminated
                ?>
              </select>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="change" class="btn btn-primary">Change Scholarship</button>
      </div>
      </form>

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
          extend: 'print',
          title: '',
          exportOptions: {
            columns: '1,2,3,4,5,6'
          }

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

  <script>
    $(document).ready(function() {

      $('.renewbtn').on('click', function() {

        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
          return $(this).text();
        }).get();
        console.log(data);
        $('#update_id').val(data[0]);
        $('#type').val(data[1]);
        $('#scholarship').val(data[2]);
        $('#update_scholarship').val(data[2]);
        $('#studentno').val(data[3]);
        $('#update_studentno').val(data[3]);
        $('#name').val(data[4]);
        $('#update_name').val(data[4]);
        $('#course').val(data[5]);
        $('#update_course').val(data[5]);
        $('#yearlevel').val(data[6]);
        $('#update_yearlevel').val(data[6]);
        $('#academicyear').val(data[7]);
        $('#semester').val(data[8]);
        $('#dateofbirth').val(data[9]);
        $('#gender').val(data[10]);
        $('#address').val(data[11]);
        $('#civilstatus').val(data[12]);
        $('#citizenship').val(data[13]);
        $('#contactno').val(data[14]);
        $('#zipcode').val(data[15]);
        $('#email').val(data[16]);
        $('#fatherstatus').val(data[17]);
        $('#fathername').val(data[18]);
        $('#fatheroccupation').val(data[19]);
        $('#fathereducation').val(data[20]);
        $('#motherstatus').val(data[21]);
        $('#mothername').val(data[22]);
        $('#motheroccupation').val(data[23]);
        $('#mothereducation').val(data[24]);
        $('#totalgrossincome').val(data[25]);
        $('#siblings').val(data[26]);
        $('#status').val(data[27]);
        $('#update_accountid').val(data[28]);
      });
    });
  </script>


  <script>
    $(document).ready(function() {

      $('.editbtn').on('click', function() {

        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
          return $(this).text();
        }).get();
        console.log(data);
        $('#update_id').val(data[0]);
        $('#type').val(data[1]);
        $('#scholarship').val(data[2]);
        $('#update_scholarship').val(data[2]);
        $('#studentno').val(data[3]);
        $('#update_studentno').val(data[3]);
        $('#name').val(data[4]);
        $('#update_name').val(data[4]);
        $('#course').val(data[5]);
        $('#update_course').val(data[5]);
        $('#yearlevel').val(data[6]);
        $('#update_yearlevel').val(data[6]);
        $('#academicyear').val(data[7]);
        $('#semester').val(data[8]);
        $('#dateofbirth').val(data[9]);
        $('#gender').val(data[10]);
        $('#address').val(data[11]);
        $('#civilstatus').val(data[12]);
        $('#citizenship').val(data[13]);
        $('#contactno').val(data[14]);
        $('#zipcode').val(data[15]);
        $('#email').val(data[16]);
        $('#fatherstatus').val(data[17]);
        $('#fathername').val(data[18]);
        $('#fatheroccupation').val(data[19]);
        $('#fathereducation').val(data[20]);
        $('#motherstatus').val(data[21]);
        $('#mothername').val(data[22]);
        $('#motheroccupation').val(data[23]);
        $('#mothereducation').val(data[24]);
        $('#totalgrossincome').val(data[25]);
        $('#siblings').val(data[26]);
        $('#status').val(data[27]);
        $('#update_accountid').val(data[28]);
        $('#score').val(data[29]);
      });
    });
  </script>
  <script>
    $(document).ready(function() {

      $('.changebtn').on('click', function() {

        $('#changemodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
          return $(this).text();
        }).get();
        console.log(data);
        $('#change_id').val(data[0]);
        $('#change_scholarship').val(data[2]);
        $('#change_studentno').val(data[3]);
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