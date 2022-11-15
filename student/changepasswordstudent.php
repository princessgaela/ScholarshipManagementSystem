<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "dbscholarship";


$con = new mysqli($hostname, $username, $password, $dbname);
if(isset($_POST["id"])){
    $Sql = "SELECT * FROM users WHERE id = '" . $_POST["id"] . "'";
    $result = mysqli_query($con, $Sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '
      <input type="hidden" name="correctoldpass" id="correctoldpass" value="' . $row['password'] . '">

      <div class="form-group">
        <label> Old Password </label>
        <input required  type="password" id="oldpassword" name="oldpassword" class="form-control">
      </div>

      <div class="form-group">
        <label> New Password </label>
        <input required  type="password" id="newpassword" name="newpassword" class="form-control">
      </div>

      <div class=" form-group">
        <label> Retype New Password </label>
        <input required  type="password" id="retypenewpassword" name="retypenewpassword" class="form-control">
      </div>';
    }
}
?>