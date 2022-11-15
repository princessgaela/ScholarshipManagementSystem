<?php
// connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'dbscholarship');

// Uploads files
if (isset($_POST['submitrenewal'])) {
    $type = mysqli_real_escape_string($conn,$_POST['type']);
    $scholarship = mysqli_real_escape_string($conn,$_POST['scholarship']);
    $academicyear = mysqli_real_escape_string($conn,$_POST['academicyear']);
    $semester = mysqli_real_escape_string($conn,$_POST['semester']);
    $studentno = mysqli_real_escape_string($conn,$_POST['studentno']);
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $course = mysqli_real_escape_string($conn,$_POST['course']);
    $yearlevel = mysqli_real_escape_string($conn,$_POST['yearlevel']);
    $contactno = mysqli_real_escape_string($conn,$_POST['contactno']);
    $status = mysqli_real_escape_string($conn,"Pending");
    $notification = mysqli_real_escape_string($conn,$scholarship . ' Scholarship renewal request has been receive from ' . $studentno);
    $notifstatus = 0;
    $notiffor = mysqli_real_escape_string($conn,'Admin');
    $accountid = $_SESSION['ID'];
    $filename = $_FILES['file']['name'];



    // destination of the file on the server
    $destination = 'requirements/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        echo "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['file']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO 'scholarshiprequest' ('type', 'scholarship', 'academicyear','semester','studentno','name','course','yearlevel','contactno','status','notification','notifstatus','notiffor','accountid','requirements') VALUES ('$type', '$scholarship', '$academicyear','$semester','$studentno','$name','$course','$yearlevel','$contactno','$status','$notification','$notifstatus','$notiffor','$accountid','$filename')";
            if (mysqli_query($conn, $sql)) {
                echo "File uploaded successfully";
            }
        } else {
            echo "Failed to upload file.";
        }
    }
}

if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM scholarshiprequest WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'requirements/' . $file['requirements'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('requirements/' . $file['requirements']));
        readfile('requirements/' . $file['requirements']);
        exit;
    }
}

?>