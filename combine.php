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
                $sql = "INSERT into scholars (emp_id,firstname,lastname,email,reg_date) 
                   values ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "','" . $getData[4] . "')";
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
    $Sql = "SELECT * FROM scholars";
    $result = mysqli_query($con, $Sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<div id='tablediv' class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr><th>ID</th>
                        <th>Student No.</th>
                          <th>Last Name</th>
                          <th>First Name</th>
                          <th>Middle Name</th>
                          <th>Course</th>
                          <th>Year Level</th>
                          <th>Scholarship</th>
                        </tr></thead><tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['id'] . "</td>
                   <td>" . $row['studentno'] . "</td>
                   <td>" . $row['lastname'] . "</td>
                   <td>" . $row['firstname'] . "</td>
                   <td>" . $row['middlename'] . "</td>
                   <td>" . $row['course'] . "</td>
                   <td>" . $row['yearlevel'] . "</td>
                   <td>" . $row['scholarship'] . "</td></tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "you have no records";
    }
}
?>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
</head>


<body>
    <div class="container">
        <div class="row">
            <form class="form-horizontal" action="scholars.php" method="post" name="upload_excel" enctype="multipart/form-data">
                <fieldset>
                    <!-- Form Name -->
                    <legend>Form Name</legend>
                    <!-- File Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="filebutton">Select File</label>
                        <div class="col-md-4">
                            <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.csv" name="file" id="file" class="input-large">
                        </div>
                    </div>
                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                        <div class="col-md-4">
                            <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <?php
        get_all_records();
        ?>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script>
        $(function() {
            $('#myTable').DataTable({
                "pageLength": 10,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
            });
        });
    </script>

</body>

</html>