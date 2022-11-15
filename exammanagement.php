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

$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');


if (isset($_POST['insertdata'])) {
    $question = mysqli_real_escape_string($connection, $_POST['question']);
    $option1 = mysqli_real_escape_string($connection, $_POST['option1']);
    $option2 = mysqli_real_escape_string($connection, $_POST['option2']);
    $option3 = mysqli_real_escape_string($connection, $_POST['option3']);
    $option4 = mysqli_real_escape_string($connection, $_POST['option4']);
    $correctanswer = mysqli_real_escape_string($connection, $_POST['correctanswer']);
    if($correctanswer=='Option 1'){
        $correctanswervalue = $option1;
    }
    else if($correctanswer=='Option 2'){
        $correctanswervalue = $option2;
    }
    else if($correctanswer=='Option 3'){
        $correctanswervalue = $option3;
    }
    else if($correctanswer=='Option 4'){
        $correctanswervalue = $option4;
    }

    $description = mysqli_real_escape_string($connection, "Added a Question to the Exam");
    $author = $_SESSION['NAME'];

    $query = "INSERT INTO exam (`question`,`option1`,`option2`,`option3`,`option4`,`correctanswer`) VALUES ('$question','$option1','$option2','$option3','$option4','$correctanswervalue')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $query = "INSERT INTO userlogs (`description`,`author`) VALUES ('$description','$author')";
        $query_run = mysqli_query($connection, $query);
        echo '<script> alert("Question Added"); </script>';
    } else {
        echo '<script> alert("Question Not Added"); </script>';
    }
}
?>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');


if (isset($_POST['updatedata'])) {
    extract($_POST);
    $id = $_POST['update_id'];

    $question = mysqli_real_escape_string($connection, $_POST['question']);
    $option1 = mysqli_real_escape_string($connection, $_POST['option1']);
    $option2 = mysqli_real_escape_string($connection, $_POST['option2']);
    $option3 = mysqli_real_escape_string($connection, $_POST['option3']);
    $option4 = mysqli_real_escape_string($connection, $_POST['option4']);
    $correctanswer = mysqli_real_escape_string($connection, $_POST['correctanswer']);
    if($correctanswer=='Option 1'){
        $correctanswervalue = $option1;
    }
    else if($correctanswer=='Option 2'){
        $correctanswervalue = $option2;
    }
    else if($correctanswer=='Option 3'){
        $correctanswervalue = $option3;
    }
    else if($correctanswer=='Option 4'){
        $correctanswervalue = $option4;
    }

    $description = mysqli_real_escape_string($connection, "Updated a Question");
    $author = $_SESSION['NAME'];

    $query = "UPDATE exam SET question='$question', option1='$option1', option2='$option2', option3='$option3', option4='$option4', correctanswer='$correctanswervalue' WHERE id='$id'  ";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $query = "INSERT INTO userlogs (`description`,`author`) VALUES ('$description','$author')";
        $query_run = mysqli_query($connection, $query);
        echo '<script> alert("Question Updated"); </script>';
    } else {
        echo '<script> alert("Question Not Updated"); </script>';
    }
}
?>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];
    $description = mysqli_real_escape_string($connection, "Deleted a Question");
    $author = $_SESSION['NAME'];

    $query = "DELETE FROM exam WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $query = "INSERT INTO userlogs (`description`,`author`) VALUES ('$description','$author')";
        $query_run = mysqli_query($connection, $query);
        echo '<script> alert("Question Deleted"); </script>';
    } else {
        echo '<script> alert("Question Not Deleted"); </script>';
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
    $Sql = "SELECT * FROM exam";
    $result = mysqli_query($con, $Sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<div id='tablediv' class='table-responsive table-hover'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr><th style='display:none;'>ID</th>
                        <th>Question</th>
                          <th>Option 1</th>
                          <th>Option 2</th>
                          <th>Option 3</th>
                          <th>Option 4</th>
                          <th>Correct Answer</th>
                          <th></th>
                          <th></th>
                        </tr></thead><tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td style='display:none;'>" . $row['id'] . "</td>
                   <td>" . $row['question'] . "</td>
                   <td>" . $row['option1'] . "</td>
                   <td>" . $row['option2'] . "</td>
                   <td>" . $row['option3'] . "</td>
                   <td>" . $row['option4'] . "</td>
                   <td>" . $row['correctanswer'] . "</td>
                   <td><button type='button' class='btn btn-success editbtn'> EDIT </button></td>
                   <td><button type='button' class='btn btn-danger deletebtn'> DELETE </button></td></tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<div id='tablediv' class='table-responsive table-hover'><table id='myTable' class='table table-striped table-bordered'>
        <thead><tr><th style='display:none;'>ID</th>
        <th>Question</th>
        <th>Option 1</th>
        <th>Option 2</th>
        <th>Option 3</th>
        <th>Option 4</th>
        <th>Correct Answer</th>
                     <th></th>
                     <th></th>
                   </tr></thead><tbody>";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Exam Management</title>
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

    .deletebtn {
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
                <a href="scholarshiprequest.php"><i class="bi bi-envelope"></i> Scholarship Request</a>
                <a href="exammanagement.php" class="active"><i class="bi bi-journal-text"></i> Exam Management</a>
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
                    <form style="background:#f1f1f1;" class="form-horizontal" action="announcement.php" method="post" name="upload_excel" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Exam Management</legend>
                            <!-- File Button -->
                            <div class="form-group">
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#studentaddmodal">
                                        Add Questions
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                </div>
                            </div>
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
                <form action="announcement.php" method="POST">
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
                <form action="announcement.php" method="POST">
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



    <!-- Modal -->
    <div class="modal fade" id="studentaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="exammanagement.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Questions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label> Question </label>
                            <input required type="text" name="question" class="form-control" placeholder="Question">
                        </div>

                        <div class="form-group">
                            <label> Option 1 </label>
                            <input required type="text" name="option1" class="form-control" placeholder="Option 1">
                        </div>
                        <div class="form-group">
                            <label> Option 2 </label>
                            <input required type="text" name="option2" class="form-control" placeholder="Option 2">
                        </div>
                        <div class="form-group">
                            <label> Option 3 </label>
                            <input required type="text" name="option3" class="form-control" placeholder="Option 3">
                        </div>
                        <div class="form-group">
                            <label> Option 4 </label>
                            <input required type="text" name="option4" class="form-control" placeholder="Option 4">
                        </div>
                        <div class="form-group">
                            <label> Correct Answer </label>
                            <select required name="correctanswer" class="form-control">
                                <option></option>
                                <option value="Option 1">Option 1</option>
                                <option value="Option 2">Option 2</option>
                                <option value="Option 3">Option 3</option>
                                <option value="Option 4">Option 4</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="insertdata" class="btn btn-primary">Save Question</button>
            </div>
            </form>

        </div>
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">


                <form action="exammanagement.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Edit Question </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">
                        <div class="form-group">
                            <label> Question </label>
                            <input required type="text" name="question" id="question" class="form-control" placeholder="Question">
                        </div>

                        <div class="form-group">
                            <label> Option 1 </label>
                            <input required type="text" name="option1" id="option1" class="form-control" placeholder="Option 1">
                        </div>
                        <div class="form-group">
                            <label> Option 2 </label>
                            <input required type="text" name="option2" id="option2" class="form-control" placeholder="Option 2">
                        </div>
                        <div class="form-group">
                            <label> Option 3 </label>
                            <input required type="text" name="option3" id="option3" class="form-control" placeholder="Option 3">
                        </div>
                        <div class="form-group">
                            <label> Option 4 </label>
                            <input required type="text" name="option4" id="option4" class="form-control" placeholder="Option 4">
                        </div>
                        <div class="form-group">
                            <label> Correct Answer </label>
                            <select required id="correctanswer" name="correctanswer" class="form-control">
                                <option></option>
                                <option value="Option 1">Option 1</option>
                                <option value="Option 2">Option 2</option>
                                <option value="Option 3">Option 3</option>
                                <option value="Option 4">Option 4</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
            </div>
            </form>

        </div>
    </div>

    <!-- DELETE POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">


                <form action="exammanagement.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Delete Question </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <input type="hidden" name="subject" id="deletesubject">
                        <h4> Do you want to delete this Question ??</h4>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                <button type="submit" name="deletedata" class="btn btn-primary"> Yes !! Delete it. </button>
            </div>
            </form>

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
                dom: "<'row'<'col-sm-12'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-1'i>>",
                "pageLength": 10,
                "paging": false,
                "lengthChange": false,
                "searching": false,
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

            $('.deletebtn').on('click', function() {

                $('#deletemodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_id').val(data[0]);
                $('#deletesubject').val(data[1]);

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
                $('#question').val(data[1]);
                $('#option1').val(data[2]);
                $('#option2').val(data[3]);
                $('#option3').val(data[4]);
                $('#option4').val(data[5]);
                $('#correctanswer').val(data[6]);

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