<?php
include_once('checkuser.php');
?>
<?php

$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');

$sql = "SELECT * FROM `scholarships`";
$all_scholarships = mysqli_query($connection, $sql);

if (isset($_POST['insertdata'])) {
    $studentno = $_POST['studentno'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $course = $_POST['course'];
    $yearlevel = $_POST['yearlevel'];
    $scholarship = $_POST['scholarship'];


    $query = "INSERT INTO scholars (`studentno`,`lastname`,`firstname`,`middlename`,`course`,`yearlevel`,`scholarship`) VALUES (UPPER('$studentno'),UPPER('$lastname'),UPPER('$firstname'),UPPER('$middlename'),UPPER('$course'),UPPER('$yearlevel'),UPPER('$scholarship'))";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        echo '<script> alert("Data Saved"); </script>';
        header('Location: scholars.php');
    } else {
        echo '<script> alert("Data Not Saved"); </script>';
    }
}

?>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');

$sqledit = "SELECT * FROM `scholarships`";
$all_scholarshipsedit = mysqli_query($connection, $sqledit);

if (isset($_POST['updatedata'])) {
    $id = $_POST['update_id'];

    $studentno = $_POST['studentno'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $course = $_POST['course'];
    $yearlevel = $_POST['yearlevel'];
    $scholarship = $_POST['scholarship'];

    $query = "UPDATE scholars SET studentno=UPPER('$studentno'), lastname=UPPER('$lastname'), firstname=UPPER('$firstname'), middlename=UPPER('$middlename'), course=UPPER('$course'), yearlevel=UPPER('$yearlevel'), scholarship=UPPER('$scholarship') WHERE id='$id'  ";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        echo '<script> alert("Data Updated"); </script>';
        header("Location:scholars.php");
    } else {
        echo '<script> alert("Data Not Updated"); </script>';
    }
}
?>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'dbscholarship');

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];

    $query = "DELETE FROM scholars WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        echo '<script> alert("Data Deleted"); </script>';
        header("Location:scholars.php");
    } else {
        echo '<script> alert("Data Not Deleted"); </script>';
    }
}

?>
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "dbscholarship";

// Create database connection 
$con = new mysqli($hostname, $username, $password, $dbname);
if (isset($_POST["Import"])) {

    $allowed = array('csv', 'xlsx', 'xls');
    $filename = $_FILES['file']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed)) {
        echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"scholars.php\"
              </script>";
    } else {
        $filename = $_FILES["file"]["tmp_name"];
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sql = "INSERT into scholars (id,studentno,lastname,firstname,middlename,course,yearlevel,scholarship) 
                   values ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "','" . $getData[4] . "','" . $getData[5] . "','" . $getData[6] . "','" . $getData[7] . "')";
                $result = mysqli_query($con, $sql);
                if (!isset($result)) {
                    echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"scholars.php\"
              </script>";
                } else {
                    echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"scholars.php\"
          </script>";
                }
            }

            fclose($file);
        }
    }
}

function get_all_records()
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname   = "dbscholarship";
    $con = new mysqli($hostname, $username, $password, $dbname);
    $Sql = "SELECT * FROM scholars ";
    $result = mysqli_query($con, $Sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<div id='tablediv' class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr><th>ID</th>
                        <th>Student No.</th>
                          <th style='display:none;'>Last Name</th>
                          <th style='display:none;'>First Name</th>
                          <th style='display:none;'>Middle Name</th>
                          <th>Course</th>
                          <th>Year Level</th>
                          <th>Scholarship</th>
                          <th></th>
                          <th></th>
                        </tr></thead><tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['id'] . "</td>
                   <td>" . $row['studentno'] . "</td>
                   <td>" . $row['lastname'] . "</td>
                   <td>" . $row['firstname'] . "</td>
                   <td>" . $row['middlename'] . "</td>
                   <td>" . $row['course'] . "</td>
                   <td>" . $row['yearlevel'] . "</td>
                   <td>" . $row['scholarship'] . "</td>
                   <td><button type='button' class='btn btn-success editbtn'> EDIT </button></td>
                   <td><button type='button' class='btn btn-danger deletebtn'> DELETE </button></td></tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "you have no records";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Scholars</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


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
                <p class="navbar-text navbar-right">Scholars</p>
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

    <div class="container-fluid" style="padding-top: 50px;">
        <div class="row">
            <div class="col-sm-2 sidenav">
                
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
            <div class="col-sm-10">
                <div class="container-fluid">
                    <form class="form-horizontal" action="scholars.php" method="post" name="upload_excel" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Scholars</legend>
                            <!-- File Button -->
                            <div class="form-group">
                                <div class="col-sm-4">

                                </div>

                                <div class="col-sm-4">
                                    <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.csv" name="file" id="file" class="input-large">
                                    <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#studentaddmodal">
                                        Add Scholar
                                    </button>
                                </div>
                                <div class="col-sm-4">

                                </div>
                            </div>
                            <!-- Button -->
                            <div class="form-group">

                                <div class="col-md-4">

                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <?php
                get_all_records();
                ?>



            </div>

        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="studentaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">


                <form action="scholars.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Scholar Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label> Student No. </label>
                            <input type="text" name="studentno" class="form-control" placeholder="Student No." onkeydown="return numbersOnly(event);">
                        </div>

                        <div class="form-group">
                            <label> Last Name </label>
                            <input type="text" name="lastname" class="form-control" placeholder="Last Name" onkeydown="return alphaOnly(event);">
                        </div>

                        <div class="form-group">
                            <label> First Name </label>
                            <input type="text" name="firstname" class="form-control" placeholder="First Name" onkeydown="return alphaOnly(event);">
                        </div>

                        <div class="form-group">
                            <label> Middle Name </label>
                            <input type="text" name="middlename" class="form-control" placeholder="Middle Name" onkeydown="return alphaOnly(event);">
                        </div>

                        <div class="form-group">
                            <label> Course </label>
                            <select id="course" name="course" class="form-control">
                                <option value="BSIT">BSIT</option>
                                <option value="BSPharma">BSPharma</option>
                                <option value="BSA">BSA</option>
                                <option value="BSCE">BSCE</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label> Year Level </label>
                            <select id="yearlevel" name="yearlevel" class="form-control">
                                <option value="1st Year">First Year</option>
                                <option value="Second Year">Second Year</option>
                                <option value="Third Year">Third Year</option>
                                <option value="Fourth Year">Fourth Year</option>
                                <option value="Fifth Year">Fifth Year</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label> Scholarship </label>
                            <select id="scholarship" name="scholarship" class="form-control">
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
                <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
            </div>
            </form>

        </div>
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">


                <form action="scholars.php" method="POST">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Edit Scholar Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                            <label> Student No. </label>
                            <input disabled type="text" id="studentno" name="studentno" class="form-control" placeholder="Student No." onkeydown="return numbersOnly(event);">
                        </div>

                        <div class="form-group">
                            <label> Last Name </label>
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" onkeydown="return alphaOnly(event);">
                        </div>

                        <div class="form-group">
                            <label> First Name </label>
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" onkeydown="return alphaOnly(event);">
                        </div>

                        <div class="form-group">
                            <label> Middle Name </label>
                            <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Middle Name" onkeydown="return alphaOnly(event);">
                        </div>

                        <div class="form-group">
                            <label> Course </label>
                            <select id="course" name="course" class="form-control">
                                <option value="BSIT">BSIT</option>
                                <option value="BSPharma">BSPharma</option>
                                <option value="BSA">BSA</option>
                                <option value="BSCE">BSCE</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label> Year Level </label>
                            <select id="yearlevel" name="yearlevel" class="form-control">
                                <option value="1st Year">First Year</option>
                                <option value="Second Year">Second Year</option>
                                <option value="Third Year">Third Year</option>
                                <option value="Fourth Year">Fourth Year</option>
                                <option value="Fifth Year">Fifth Year</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label> Scholarship </label>
                            <select id="scholarship" name="scholarship" class="form-control">
                                <?php
                                // use a while loop to fetch data 
                                // from the $all_categories variable 
                                // and individually display as an option
                                while ($scholarship = mysqli_fetch_array(
                                    $all_scholarships,
                                    MYSQLI_ASSOC
                                )) :;
                                ?>
                                    <option value="<?php echo $scholarship["name"];
                                                    // The value we usually set is the primary key
                                                    ?>">
                                        <?php echo $scholarship["name"];
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
                <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
            </div>
            </form>

        </div>
    </div>

    <!-- DELETE POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">


                <form action="scholars.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Delete Scholar Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_id">

                        <h4> Do you want to delete this Scholar ??</h4>
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
                dom: "<'row'<'col-sm-1'<'btn btn-primary'B>><'col-sm-1'l><'col-sm-10'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                    extend: 'print',
                    exportOptions: {
                        columns: '0,1,2,3,4,5,6,7'
                    }
                }],
                "pageLength": 10,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,

            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.viewbtn').on('click', function() {
                $('#viewmodal').modal('show');
                $.ajax({ //create an ajax request to display.php
                    type: "GET",
                    url: "useraccount.php",
                    dataType: "html", //expect html to be returned                
                    success: function(response) {
                        $("#responsecontainer").html(response);
                        //alert(response);
                    }
                });
            });

        });
    </script>


    <script>
        $(document).ready(function() {

            $('#datatableid').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Your Data",
                }
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
                $('#studentno').val(data[1]);
                $('#lastname').val(data[2]);
                $('#firstname').val(data[3]);
                $('#middlename').val(data[4]);
                $('#course').val(data[5]);
                $('#yearlevel').val(data[6]);
                $('#schlarship').val(data[7]);
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