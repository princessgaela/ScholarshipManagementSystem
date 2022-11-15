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
      <div class="form-group">
        <label> Name </label>
        <input required  type="text" id="name" name="name" class="form-control" value="' . $row['name'] . '">
      </div>

      <div class="form-group">
        <label> Address </label>
        <input required  type="text" id="address" name="address" class="form-control" value="' . $row['address'] . '">
      </div>

      <div class=" form-group">
        <label> Email Address </label>
        <input required  type="email" id="emailaddress" name="emailaddress" class="form-control" value="' . $row['emailaddress'] . '">
      </div>

      <div class="form-group">
        <label> Contact No. </label>
        <input required  type="text" id="contactno" name="contactno" class="form-control" value="' . $row['contactno'] . '">
      </div>';
    }
}
?>