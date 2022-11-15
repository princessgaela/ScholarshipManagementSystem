<!doctype html>
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
$conn = mysqli_connect('localhost', 'root', '', 'dbscholarship');

// Uploads files
if (isset($_POST['submitrenewal'])) {
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $scholarship = mysqli_real_escape_string($connection, $_POST['scholarshipr']);
    $academicyear = mysqli_real_escape_string($connection, $_POST['academicyear']);
    $semester = mysqli_real_escape_string($connection, $_POST['semester']);
    $studentno = mysqli_real_escape_string($connection, $_POST['studentno']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $course = mysqli_real_escape_string($connection, $_POST['course']);
    $yearlevel = mysqli_real_escape_string($connection, $_POST['yearlevel']);
    $dateofbirth = mysqli_real_escape_string($connection, $_POST['dateofbirth']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $civilstatus = mysqli_real_escape_string($connection, $_POST['civilstatus']);
    $citizenship = mysqli_real_escape_string($connection, $_POST['citizenship']);
    $contactno = mysqli_real_escape_string($connection, $_POST['contactno']);
    $zipcode = mysqli_real_escape_string($connection, $_POST['zipcode']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
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
    $status = "Pending";
    $notification = $scholarship . ' Scholarship renewal request has been receive from ' . $studentno;
    $notifstatus = 0;
    $notiffor = 'Admin';
    $accountid = $_SESSION['ID'];
    $filename = $_FILES['file']['name'];

    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    // destination of the file on the server
    $newfile = md5($filename) . time() . "." . $extension;
    $destination = 'requirements/' . $newfile;

    // get the file extension


    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];


    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        echo "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['file']['size'] > 10000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO `scholarshiprequest` (`type`, `scholarship`, `studentno`, `name`, `course`, `yearlevel`, `academicyear`, `semester`, `dateofbirth`, `gender`, `address`, `civilstatus`, `citizenship`, `contactno`, `zipcode`, `email`, `fatherstatus`, `fathername`, `fatheroccupation`, `fathereducation`, `motherstatus`, `mothername`, `motheroccupation`, `mothereducation`, `totalgrossincome`, `siblings`, `status`,`notification`,`notifstatus`,`notiffor`,`accountid`,`requirements`) VALUES (UPPER('$type'),UPPER('$scholarship'),UPPER('$studentno'),UPPER('$name'),UPPER('$course'),UPPER('$yearlevel'),UPPER('$academicyear'),UPPER('$semester'),UPPER('$dateofbirth'),UPPER('$gender'),UPPER('$address'),UPPER('$civilstatus'),UPPER('$citizenship'),UPPER('$contactno'),UPPER('$zipcode'),UPPER('$email'),UPPER('$fatherstatus'),UPPER('$fathername'),UPPER('$fatheroccupation'),UPPER('$fathereducation'),UPPER('$motherstatus'),UPPER('$mothername'),UPPER('$motheroccupation'),UPPER('$mothereducation'),UPPER('$totalgrossincome'),UPPER('$siblings'),UPPER('$status'),'$notification','$status','$notiffor','$accountid','$newfile')";
            if (mysqli_query($conn, $sql)) {
                echo '<script> alert("Data Saved"); </script>';
                header('Location: scholarships.php');
            }
        } else {
            echo '<script> alert("Data Not Saved"); </script>';
        }
    }
}


?>
<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');
if (isset($_POST['submitapplication'])) {
    $score = mysqli_real_escape_string($connection, $_POST['score']);
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $scholarship = mysqli_real_escape_string($connection, $_POST['scholarship']);
    $academicyear = mysqli_real_escape_string($connection, $_POST['academicyear']);
    $semester = mysqli_real_escape_string($connection, $_POST['semester']);
    $studentno = mysqli_real_escape_string($connection, $_POST['studentno']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $course = mysqli_real_escape_string($connection, $_POST['course']);
    $yearlevel = mysqli_real_escape_string($connection, $_POST['yearlevel']);
    $dateofbirth = mysqli_real_escape_string($connection, $_POST['dateofbirth']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $civilstatus = mysqli_real_escape_string($connection, $_POST['civilstatus']);
    $citizenship = mysqli_real_escape_string($connection, $_POST['citizenship']);
    $contactno = mysqli_real_escape_string($connection, $_POST['contactno']);
    $zipcode = mysqli_real_escape_string($connection, $_POST['zipcode']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
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
    $status = mysqli_real_escape_string($connection, "Pending");
    $notification = mysqli_real_escape_string($connection, $scholarship . ' Scholarship application has been receive from ' . $studentno);
    $notifstatus = 0;
    $notiffor = mysqli_real_escape_string($connection, 'Admin');
    $accountid = $_SESSION['ID'];

    $query = "INSERT INTO `scholarshiprequest` (`examscore`, `type`, `scholarship`, `studentno`, `name`, `course`, `yearlevel`, `academicyear`, `semester`, `dateofbirth`, `gender`, `address`, `civilstatus`, `citizenship`, `contactno`, `zipcode`, `email`, `fatherstatus`, `fathername`, `fatheroccupation`, `fathereducation`, `motherstatus`, `mothername`, `motheroccupation`, `mothereducation`, `totalgrossincome`, `siblings`, `status`,`notification`,`notifstatus`,`notiffor`,`accountid`) VALUES (UPPER('$score'),UPPER('$type'),UPPER('$scholarship'),UPPER('$studentno'),UPPER('$name'),UPPER('$course'),UPPER('$yearlevel'),UPPER('$academicyear'),UPPER('$semester'),UPPER('$dateofbirth'),UPPER('$gender'),UPPER('$address'),UPPER('$civilstatus'),UPPER('$citizenship'),UPPER('$contactno'),UPPER('$zipcode'),UPPER('$email'),UPPER('$fatherstatus'),UPPER('$fathername'),UPPER('$fatheroccupation'),UPPER('$fathereducation'),UPPER('$motherstatus'),UPPER('$mothername'),UPPER('$motheroccupation'),UPPER('$mothereducation'),UPPER('$totalgrossincome'),UPPER('$siblings'),UPPER('$status'),'$notification','$status','$notiffor','$accountid')";
    $query_run = mysqli_query($connection, $query);
    if ($query_run) {
        echo '<script> alert("Data Saved"); </script>';
        header('Location: scholarships.php');
    } else {
        echo '<script> alert("Data Not Saved"); </script>';
    }
}

?>
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "dbscholarship";
$con = new mysqli($hostname, $username, $password, $dbname);



if (isset($_POST['submitfeedback'])) {
    $Sql = "SELECT * FROM currentyear";
    $result = mysqli_query($connection, $Sql);
    $row = mysqli_fetch_assoc($result);
    $year = $row['year'];
    $semester = $row['semester'];
    $scholarshipf = mysqli_real_escape_string($con, $_POST['scholarshipf']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $query = "INSERT INTO `feedbacks` (`scholarship`, `message`, `name`, `course`, `email`, `academicyear`, `semester`) VALUES ('$scholarshipf', '$message', '$name', '$course', '$email','$year','$semester')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        echo '<script> alert("Data Saved"); </script>';
        header('Location: scholarships.php');
    } else {
        echo ("Error description: " . $con->error);
    }
}
?>
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "dbscholarship";
$con = new mysqli($hostname, $username, $password, $dbname);
if (isset($_POST['submitexam'])) {
    $studentno = $_SESSION['STUDENTNO'];
    $accountid = $_SESSION['ID'];
    $Sql = "SELECT * FROM currentyear";
    $result = mysqli_query($connection, $Sql);
    $row = mysqli_fetch_assoc($result);
    $year = $row['year'];
    $semester = $row['semester'];
    $totalQuestions = 0;
    $correctAnswers = 0;
    foreach ($_POST as $key => $value) {
        if ($key == 'submitexam') {
        } else {
            $tempAnswer = $_POST[$key];
            // count total questions and correct answers
            $sqlAnswer = "select  count(*) count from exam where id = '$key' and correctanswer = '$tempAnswer'";
            $resultAnswer = mysqli_query($con, $sqlAnswer);
            $rowAnswer = mysqli_fetch_assoc($resultAnswer);
            $numAnswer = $rowAnswer['count'];

            if ($numAnswer < 1) {
                // wrong answer
            } else {
                // correct answer
                $correctAnswers++;
            }
            $totalQuestions++;
        }
    }
    $grade = ($correctAnswers / $totalQuestions) * 100;
    // Store score in db
    $sqlSubmit = "insert into examscores (studentno, score, academicyear,semester,accountid) values ('$studentno', '$grade', '$year', '$semester', '$accountid')";
    if (mysqli_query($con, $sqlSubmit)) {
        header('Location: scholarships.php');
    } else {
        header('Location: scholarships.php');
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
        if ($semester == '1st Semester') {
            $lastyear = $year - 1;
            $lastsemester = '2ND SEMESTER';
        } else if ($semester == '2nd Semester') {
            $lastyear = $year;
            $lastsemester = '1ST SEMESTER';
        }
        $Sql = "SELECT * FROM scholarships";
        $result = mysqli_query($con, $Sql);
        $userid = $_SESSION['ID'];
        $studentno = $_SESSION['STUDENTNO'];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $scholarship = $row['name'];
                $Sqlsss = "SELECT * FROM scholarshiprequest WHERE type LIKE 'APPLICATION' AND status LIKE 'APPROVED' AND scholarship LIKE '$scholarship' AND academicyear = '$year' AND semester LIKE '$semester'";
                $resultsss = mysqli_query($con, $Sqlsss);
                $scholarcount = mysqli_num_rows($resultsss);
                $slot = $row['slot'];
                $availableslot = $slot - $scholarcount;
                echo '<div class="col">
                    <div class="card text-center">
                    <div style="background: #f1f1f1;" class="card-body">
                    <h5 class="card-title">' . $row['name'] . '</h5>
                    <p style="border: 1px solid  #808080;"class="card-text">' . $row['fulldescription'] . '</p>
                    <h6 class="card-text">Requirements</h6>
                    <p class="card-text" style="white-space: pre-wrap;">' . $row['requirements'] . '</p>';

                $date = new DateTime($row['deadline']);
                $now = new DateTime();
                $date->modify('+1 day');
                if ($date <= $now) {
                    echo '<h6 class="card-text">Application is Closed</h6>';
                } else {
                    if ($availableslot < 1) {
                        echo '<h6 class="card-text">No Available Slot</h6>';
                    } else {
                        echo '<h6 class="card-text">Available Slots: ' . $availableslot . '</h6>';
                        $Sqls = "SELECT * FROM scholarshiprequest WHERE scholarship LIKE '$scholarship' AND (status LIKE 'APPROVED' OR status LIKE 'PENDING') AND (accountid = '$userid' OR studentno LIKE '$studentno')";
                        $results = mysqli_query($con, $Sqls);
                        if (mysqli_num_rows($results) == 0) {
                            $Sqlss = "SELECT * FROM scholars WHERE (scholarship LIKE '$scholarship') AND (accountid = '$userid' OR studentno LIKE '$studentno') AND academicyear = '$lastyear' AND semester LIKE '$lastsemester' ";
                            $resultss = mysqli_query($con, $Sqlss);
                            if (mysqli_num_rows($resultss) > 0) {
                                $rowss = mysqli_fetch_assoc($resultss);
                                if ($rowss['scholarship'] == $row['name'] && $row['renewal'] == 1) {
                                    echo '<button type="button" class="btn btn-primary renewbtn" data-id="' . $row['name'] . '"> Renew Scholarship  </button>';
                                }
                            } else {
                                $Sqlssss = "SELECT * FROM examscores WHERE (accountid = '$userid' OR studentno LIKE '$studentno') AND academicyear = '$year' AND semester LIKE '$semester' ";
                                $resultssss = mysqli_query($con, $Sqlssss);
                                if (mysqli_num_rows($resultssss) == 0) {
                                    echo '<button type="button" class="btn btn-info exambtn" data-id="' . $row['name'] . '"> Take Examination  </button>';
                                } else {
                                    echo '<button type="button" class="btn btn-success editbtn" data-id="' . $row['name'] . '"> Fill up Application Form  </button>';
                                }
                            }
                        } else {
                        }
                    }
                }
                echo ' &nbsp<button type="button" class="btn btn-secondary feedbackbtn" data-id="' . $row['name'] . '"> Give Feedback  </button>
                </div>
                </div>
                </div>';
            }
        } else {
            echo "No Scholarships";
        }
    } else {
        echo "No School Year Set";
    }
}
?>

<?php
function get_all_question()
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname   = "dbscholarship";
    $con = new mysqli($hostname, $username, $password, $dbname);
    $Sql = "SELECT * FROM exam";
    $result = mysqli_query($con, $Sql);
    $userid = $_SESSION['ID'];
    $studentno = $_SESSION['STUDENTNO'];
    if (mysqli_num_rows($result) > 0) {
        $index = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="form-group">
            <label>' . $index . '. ' . $row['question'] . '</label><br>
            <input class="form-check-input" type="radio" name="' . $row['id'] . '" id="' . $row['option1'] . '" value="' . $row['option1'] . '">
            <label class="form-check-label" for="' . $row['id'] . 'option1">' . $row['option1'] . '</label>
            <input class="form-check-input" type="radio" name="' . $row['id'] . '" id="' . $row['option2'] . '" value="' . $row['option2'] . '">
            <label class="form-check-label" for="' . $row['id'] . 'option2">' . $row['option2'] . '</label>
            <input class="form-check-input" type="radio" name="' . $row['id'] . '" id="' . $row['option3'] . '" value="' . $row['option3'] . '">
            <label class="form-check-label" for="' . $row['id'] . 'option3">' . $row['option3'] . '</label>
            <input class="form-check-input" type="radio" name="' . $row['id'] . '" id="' . $row['option4'] . '" value="' . $row['option4'] . '">
            <label class="form-check-label" for="' . $row['id'] . 'option4">' . $row['option4'] . '</label>
        </div>';
            $index++;
        }
    }
}
?>

<html lang="en">

<head>
    <title>Scholarships</title>
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
    .description {
        border-width: thin;
    }

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
                        <a class="nav-link active" href="scholarships.php">Scholarship</a>
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


    <br><br><br>
    <div class="container-fluid">
        <div class="text-center">
            <h3 style="font-size:35px; margin-top:10px;">Scholarship Offers</h3>
        </div>
    </div>
    <div class="container-fluid" style="margin:50px 0px;">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php get_all_records() ?>
        </div><br>
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
            <p style="color: #f2f2f2; padding: 15px 0;" align="center">
                &copy; 2022 Copyright: <a href="https://up.phinma.edu.ph/">PHINMA University of pangasinan</a>
            </p>
        </div>
    </footer>





    <div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="scholarships.php" method="POST">
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
                <form action="scholarships.php" method="POST">
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
                <form action="scholarships.php" method="POST">
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

    <div class="modal fade" id="exammodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="scholarships.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Examination Form </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php get_all_question() ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                        <button type="submit" name="submitexam" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="scholarships.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Scholarship Application Form </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $hostname = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname   = "dbscholarship";
                        $userid = $_SESSION['ID'];
                        $studentno = $_SESSION['STUDENTNO'];
                        $con = new mysqli($hostname, $username, $password, $dbname);
                        $Sql = "SELECT * FROM currentyear";
                        $result = mysqli_query($con, $Sql);
                        $row = mysqli_fetch_assoc($result);
                        $year = $row['year'];
                        $semester = $row['semester'];
                        $Sqls = "SELECT * FROM users WHERE id = '$userid'";
                        $results = mysqli_query($con, $Sqls);
                        $rows = mysqli_fetch_assoc($results);
                        $Sqlssss = "SELECT * FROM examscores WHERE (accountid = '$userid' OR studentno LIKE '$studentno') AND academicyear = '$year' AND semester LIKE '$semester' ";
                        $resultssss = mysqli_query($con, $Sqlssss);
                        $rowssss = mysqli_fetch_assoc($resultssss);
                        ?>
                        <div class="form-group">
                            <label> Exam Grade </label>
                            <input readonly type="text" id="score" name="score" class="form-control" value="<?php echo $rowssss['score']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Type </label>
                            <input readonly type="text" id="type" name="type" class="form-control" value="Application">
                        </div>
                        <div class="form-group">
                            <label> Scholarship </label>
                            <input readonly type="text" id="scholarship" name="scholarship" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Academic Year </label>
                            <input readonly type="text" id="academicyear" name="academicyear" class="form-control" value="<?php echo $row['year']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Semester </label>
                            <input readonly type="text" id="semester" name="semester" class="form-control" value="<?php echo $row['semester']  ?>">
                        </div>
                        <div class=" form-group">
                            <label> Student No. </label>
                            <input readonly type="text" id="studentno" name="studentno" class="form-control" value="<?php echo $rows['studentno']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Name </label>
                            <input readonly type="text" id="name" name="name" class="form-control" value="<?php echo $rows['name']  ?>">
                        </div>
                        <div class="form-group">
                            <label> College Department</label>
                            <input readonly type="text" id="course" name="course" class="form-control" value="<?php echo $rows['course']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Year Level </label>
                            <input readonly type="text" id="yearlevel" name="yearlevel" class="form-control" value="<?php echo $rows['yearlevel']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Date Of Birth </label>
                            <input readonly type="date" id="dateofbirth" name="dateofbirth" class="form-control" value="<?php echo $rows['dateofbirth']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Gender </label>
                            <input readonly type="text" id="gender" name="gender" class="form-control" value="<?php echo $rows['gender']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Address </label>
                            <input readonly type="text" id="address" name="address" class="form-control" value="<?php echo $rows['address']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Civil Status </label>
                            <input readonly type="text" id="civilstatus" name="civilstatus" class="form-control" value="<?php echo $rows['civilstatus']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Citizenship </label>
                            <input readonly type="text" id="citizenship" name="citizenship" class="form-control" value="<?php echo $rows['citizenship']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Contact No. </label>
                            <input readonly type="text" id="contactno" name="contactno" class="form-control" value="<?php echo $rows['contactno']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Zip Code </label>
                            <input readonly type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo $rows['zipcode']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Email </label>
                            <input readonly type="text" id="email" name="email" class="form-control" value="<?php echo $rows['emailaddress']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Father Status </label>
                            <input readonly type="text" id="fatherstatus" name="fatherstatus" class="form-control" value="<?php echo $rows['fatherstatus']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Father Name </label>
                            <input readonly type="text" id="fathername" name="fathername" class="form-control" value="<?php echo $rows['fathername']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Father Occupation </label>
                            <input readonly type="text" id="fatheroccupation" name="fatheroccupation" class="form-control" value="<?php echo $rows['fatheroccupation']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Father Education </label>
                            <input readonly type="text" id="fathereducation" name="fathereducation" class="form-control" value="<?php echo $rows['fathereducation']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Mother Status </label>
                            <input readonly type="text" id="motherstatus" name="motherstatus" class="form-control" value="<?php echo $rows['motherstatus']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Mother Name </label>
                            <input readonly type="text" id="mothername" name="mothername" class="form-control" value="<?php echo $rows['mothername']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Mother Occupation </label>
                            <input readonly type="text" id="motheroccupation" name="motheroccupation" class="form-control" value="<?php echo $rows['motheroccupation']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Mother Education </label>
                            <input readonly type="text" id="mothereducation" name="mothereducation" class="form-control" value="<?php echo $rows['mothereducation']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Total Gross Income </label>
                            <input readonly type="number" id="totalgrossincome" name="totalgrossincome" class="form-control" value="<?php echo $rows['totalgrossincome']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Siblings </label>
                            <input readonly type="number" id="siblings" name="siblings" class="form-control" value="<?php echo $rows['siblings']  ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                        <button type="submit" name="submitapplication" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="feedbackmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="scholarships.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Feedback Form </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Scholarship </label>
                            <input readonly type="text" name="scholarshipf" id="scholarshipf" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Message </label>
                            <textarea required class="form-control" name="message" id="message" cols="20" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label> Name </label>
                            <input required type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> College Department </label>
                            <select required id="course" name="course" class="form-control">
                                <option></option>
                                <option value="CAS">CAS</option>
                                <option value="CEA">CEA</option>
                                <option value="CELA">CELA</option>
                                <option value="CHS">CHS</option>
                                <option value="CITE">CITE</option>
                                <option value="CMA">CMA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Email </label>
                            <input required type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                        <button type="submit" name="submitfeedback" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="renewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="scholarships.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Scholarship Renewal Form </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $hostname = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname   = "dbscholarship";
                        $con = new mysqli($hostname, $username, $password, $dbname);
                        $Sql = "SELECT * FROM currentyear";
                        $result = mysqli_query($con, $Sql);
                        $row = mysqli_fetch_assoc($result);
                        $Sqls = "SELECT * FROM users WHERE id = '$userid'";
                        $results = mysqli_query($con, $Sqls);
                        $rows = mysqli_fetch_assoc($results);
                        ?>
                        <div class="form-group">
                            <label> Type </label>
                            <input readonly type="text" id="typer" name="type" class="form-control" value="Renewal">
                        </div>
                        <div class="form-group">
                            <label> Scholarship </label>
                            <input readonly type="text" id="scholarshipr" name="scholarshipr" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Academic Year </label>
                            <input readonly type="text" id="academicyear" name="academicyear" class="form-control" value="<?php echo $row['year']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Semester </label>
                            <input readonly type="text" id="semester" name="semester" class="form-control" value="<?php echo $row['semester']  ?>">
                        </div>
                        <div class=" form-group">
                            <label> Student No. </label>
                            <input readonly type="text" id="studentno" name="studentno" class="form-control" value="<?php echo $rows['studentno']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Name </label>
                            <input readonly type="text" id="name" name="name" class="form-control" value="<?php echo $rows['name']  ?>">
                        </div>
                        <div class="form-group">
                            <label> College Department</label>
                            <input readonly type="text" id="course" name="course" class="form-control" value="<?php echo $rows['course']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Year Level </label>
                            <input readonly type="text" id="yearlevel" name="yearlevel" class="form-control" value="<?php echo $rows['yearlevel']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Date Of Birth </label>
                            <input readonly type="date" id="dateofbirth" name="dateofbirth" class="form-control" value="<?php echo $rows['dateofbirth']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Gender </label>
                            <input readonly type="text" id="gender" name="gender" class="form-control" value="<?php echo $rows['gender']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Address </label>
                            <input readonly type="text" id="address" name="address" class="form-control" value="<?php echo $rows['address']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Civil Status </label>
                            <input readonly type="text" id="civilstatus" name="civilstatus" class="form-control" value="<?php echo $rows['civilstatus']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Citizenship </label>
                            <input readonly type="text" id="citizenship" name="citizenship" class="form-control" value="<?php echo $rows['citizenship']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Contact No. </label>
                            <input readonly type="text" id="contactno" name="contactno" class="form-control" value="<?php echo $rows['contactno']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Zip Code </label>
                            <input readonly type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo $rows['zipcode']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Email </label>
                            <input readonly type="text" id="email" name="email" class="form-control" value="<?php echo $rows['emailaddress']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Father Status </label>
                            <input readonly type="text" id="fatherstatus" name="fatherstatus" class="form-control" value="<?php echo $rows['fatherstatus']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Father Name </label>
                            <input readonly type="text" id="fathername" name="fathername" class="form-control" value="<?php echo $rows['fathername']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Father Occupation </label>
                            <input readonly type="text" id="fatheroccupation" name="fatheroccupation" class="form-control" value="<?php echo $rows['fatheroccupation']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Father Education </label>
                            <input readonly type="text" id="fathereducation" name="fathereducation" class="form-control" value="<?php echo $rows['fathereducation']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Mother Status </label>
                            <input readonly type="text" id="motherstatus" name="motherstatus" class="form-control" value="<?php echo $rows['motherstatus']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Mother Name </label>
                            <input readonly type="text" id="mothername" name="mothername" class="form-control" value="<?php echo $rows['mothername']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Mother Occupation </label>
                            <input readonly type="text" id="motheroccupation" name="motheroccupation" class="form-control" value="<?php echo $rows['motheroccupation']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Mother Education </label>
                            <input readonly type="text" id="mothereducation" name="mothereducation" class="form-control" value="<?php echo $rows['mothereducation']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Total Gross Income </label>
                            <input readonly type="number" id="totalgrossincome" name="totalgrossincome" class="form-control" value="<?php echo $rows['totalgrossincome']  ?>">
                        </div>
                        <div class="form-group">
                            <label> Siblings </label>
                            <input readonly type="number" id="siblings" name="siblings" class="form-control" value="<?php echo $rows['siblings']  ?>">
                        </div>

                        <div class="form-group">
                            <label> File Attachment </label>
                            <input required type="file" id="file" name='file' class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                            <button type="submit" name="submitrenewal" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>














</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>

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

<script>
    $(document).ready(function() {

        $('.exambtn').on('click', function() {

            $('#exammodal').modal('show');

            var ids = $(this).attr('data-id');
            $('#scholarship').val(ids);
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('.editbtn').on('click', function() {

            $('#editmodal').modal('show');

            var ids = $(this).attr('data-id');
            $('#scholarship').val(ids);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.feedbackbtn').on('click', function() {
            $('#feedbackmodal').modal('show');
            var idss = $(this).attr('data-id');
            $('#scholarshipf').val(idss);
        });
    });
</script>
<script>
    $(document).ready(function() {

        $('.renewbtn').on('click', function() {

            $('#renewmodal').modal('show');

            var idsss = $(this).attr('data-id');
            $('#scholarshipr').val(idsss);
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