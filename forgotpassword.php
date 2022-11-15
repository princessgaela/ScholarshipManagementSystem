<?php

// start session
session_start();

// Include database connectivity

include_once('config.php');


if (isset($_POST['submit'])) {

    $errorMsg = "";

    $username = $con->real_escape_string($_POST['username']);
    $newpassword = $con->real_escape_string($_POST['newpassword']);
    $confirmnewpassword = $con->real_escape_string($_POST['confirmnewpassword']);

    $datetime = date("Y-m-d H:i:s");
    $description =" Reset Password";

    $sql = "SELECT * FROM users WHERE username = '$username' ";

    $result = $con->query($sql);

    if ($result->num_rows == 0) {
        $errorMsg = 'Username not Found';
    } else {
        if ($newpassword == $confirmnewpassword) {
            $update = "UPDATE users SET password = '$newpassword' WHERE username = '$username' ";
            $result = mysqli_query($con, $update);
            $update = "INSERT INTO userlogs (`date`,`description`,`author`) VALUES ('$datetime','$description','$username')";
            $result = mysqli_query($con, $update);
            $errorMsg = 'Your new password has reset successfully, you can now login.';
        } else {
            $errorMsg = 'Password does not match';
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="x-icon" href="img/University_of_Pangasinan_logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="x-icon" href="img/University_of_Pangasinan_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>


<div class="header">
    <div class="row">
        <div class="col-sm-8">
            <img style=" height: 100px; width: auto; margin-right:15px;" class="img-responsive" src="img/University_of_Pangasinan_logo.png" class="d-inline-block align-top" alt="">
        </div>
        <div style="margin-top:-90px; margin-left:120px; padding-bottom:25px;" class="col-sm-8">
            <h1>PHINMA - UNIVERSITY OF PANGASINAN SCHOLARSHIP MANAGEMENT SYSTEM</h1>
        </div>
    </div>
</div>

<body>



    <div class="login_text">
        <h2>FORGOT PASSWORD</h2>
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="newpassword">New Password:</label>
                    <input type="password" class="form-control" name="newpassword" placeholder=" New Password">
                </div>
                <div class="form-group">
                    <label for="confirmnewpassword">Confirm New Password:</label>
                    <input type="password" class="form-control" name="confirmnewpassword" placeholder="Confirm New Password">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary btn-block" value="Submit">
                </div>

            </form>
            <a href="index.php">Sign in</a>
            <?php if (isset($errorMsg)) { ?>
                <div class="alert alert-danger alert-dismissible fade show">

                    <?php echo $errorMsg; ?>
                </div>
            <?php } ?>
        </div>

        <div class="header2">
            <h2 style="margin-top:9.5%;">"Making Lives Better Through Education"</h2>
        </div>





</body>


<footer>
    <div class="footer">
        <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
            </svg> Email Support: scma.system.up@phinmaed.com</p>
    </div>

</footer>

</html>