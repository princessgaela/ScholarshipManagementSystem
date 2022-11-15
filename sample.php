<?php
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'dbscholarship';
  
$db = new mysqli($db_host, $db_username, $db_password, $db_name);
  
if($db->connect_error){
    die("Unable to connect database: " . $db->connect_error);
}

require_once 'vendor/autoload.php';
  
use vendor\phpoffice\phpspreadsheet\src\PhpSpreadsheet\Spreadsheet;
use vendor\phpoffice\phpspreadsheet\src\PhpSpreadsheet\Reader\Csv;
use vendor\phpoffice\phpspreadsheet\src\PhpSpreadsheet\Reader\Xlsx;


if (isset($_POST['Import'])) {
  
    $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      
    if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
      
        $arr_file = explode('.', $_FILES['file']['name']);
        $extension = end($arr_file);
      
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
  
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
  
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
  
        if (!empty($sheetData)) {
            for ($i=0; $i<count($sheetData); $i++) { //skipping first row
                $studentno = $sheetData[$i][0];
                $name = $sheetData[$i][1];
                $course = $sheetData[$i][2];
                $yearlevel = $sheetData[$i][3];
                $scholarship = $sheetData[$i][4];
                if($studentno=='' || $name=='' || $course=='' || $yearlevel=='' || $scholarship==''){
                    continue;
                }
                else{
                    $db->query("INSERT INTO scholars(studentno, name, course, yearlevel, scholarship) VALUES('$studentno', '$name', '$course', '$yearlevel', '$scholarship')");
                }
                
            }
        }
        echo "Records inserted successfully.";
    } else {
        echo "Upload only CSV or Excel file.";
    }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="wrap">
        <div class="container">
            <div class="row">
                <form class="form-horizontal" action="sample.php" method="post" name="upload_excel" enctype="multipart/form-data">
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
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">Print Table</label>
                            <div class="col-md-4">
                            <input type="button" onclick="PrintTable();" value="Print"/>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <?php
            ?>
        </div>
    </div>
</body>
<script type="text/javascript">
    function PrintTable() {
        var printWindow = window.open('', '', 'height=200,width=400');
        printWindow.document.write('<html><head><title>Table Contents</title>');
 
        
        
 
        //Print the DIV contents i.e. the HTML Table.
        printWindow.document.write('<body>');
        var divContents = document.getElementById("tablediv").innerHTML;
        printWindow.document.write(divContents);
        printWindow.document.write('</body>');
 
        printWindow.document.write('</html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>

</html>