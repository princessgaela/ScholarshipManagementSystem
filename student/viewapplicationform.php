<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "dbscholarship";


$con = new mysqli($hostname, $username, $password, $dbname);
if (isset($_POST["id"])) {


  $Sql = "SELECT * FROM scholarshiprequest WHERE id = '" . $_POST["id"] . "'";
  $result = mysqli_query($con, $Sql);
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['notifstatus'] == 1 || $row['notifstatus'] == 3) {
      $query = "UPDATE `scholarshiprequest` SET `notifstatus` = '2' WHERE `scholarshiprequest`.`id` = " . $_POST["id"] . "";
      $query_run = mysqli_query($con, $query);
    }

      echo '
      <div class="form-group">
        <label> Exam Score </label>
        <input disabled type="text" id="type" name="type" class="form-control" value="' . $row['examscore'] . '">
      </div>
      <div class="form-group">
        <label> Type </label>
        <input disabled type="text" id="type" name="type" class="form-control" value="' . $row['type'] . '">
      </div>

      <div class="form-group">
        <label> Scholarship </label>
        <input disabled type="text" id="scholarship" name="scholarship" class="form-control" value="' . $row['scholarship'] . '">
      </div>

      <div class=" form-group">
        <label> Student No. </label>
        <input disabled type="text" id="studentno" name="studentno" class="form-control" value="' . $row['studentno'] . '">
      </div>

      <div class="form-group">
        <label> Name </label>
        <input disabled type="text" id="name" name="name" class="form-control" value="' . $row['name'] . '">
      </div>

      <div class="form-group">
        <label> Course </label>
        <input disabled type="text" id="course" name="course" class="form-control" value="' . $row['course'] . '">
      </div>

      <div class="form-group">
        <label> Year Level </label>
        <input disabled type="text" id="yearlevel" name="yearlevel" class="form-control" value="' . $row['yearlevel'] . '">
      </div>

      <div class="form-group">
        <label> Academic Year </label>
        <input disabled type="text" id="academicyear" name="academicyear" class="form-control" value="' . $row['academicyear'] . '">
      </div>

      <div class="form-group">
        <label> Semester </label>
        <input disabled type="text" id="semester" name="semester" class="form-control" value="' . $row['semester'] . '">
      </div>

      <div class="form-group">
        <label> Date Of Birth </label>
        <input disabled type="text" id="dateofbirth" name="dateofbirth" class="form-control" value="' . $row['dateofbirth'] . '">
      </div>

      <div class="form-group">
        <label> Gender </label>
        <input disabled type="text" id="gender" name="gender" class="form-control" value="' . $row['gender'] . '">
      </div>

      <div class="form-group">
        <label> Address </label>
        <input disabled type="text" id="address" name="address" class="form-control" value="' . $row['address'] . '">
      </div>

      <div class="form-group">
        <label> Civil Status </label>
        <input disabled type="text" id="civilstatus" name="civilstatus" class="form-control" value="' . $row['civilstatus'] . '">
      </div>

      <div class="form-group">
        <label> Citizenship </label>
        <input disabled type="text" id="citizenship" name="citizenship" class="form-control" value="' . $row['citizenship'] . '">
      </div>

      <div class="form-group">
        <label> Contact No. </label>
        <input disabled type="text" id="contactno" name="contactno" class="form-control" value="' . $row['contactno'] . '">
      </div>

      <div class="form-group">
        <label> Zip Code </label>
        <input disabled type="text" id="zipcode" name="zipcode" class="form-control" value="' . $row['zipcode'] . '">
      </div>

      <div class="form-group">
        <label> Email </label>
        <input disabled type="text" id="email" name="email" class="form-control" value="' . $row['email'] . '">
      </div>

      <div class="form-group">
        <label> Father Status </label>
        <input disabled type="text" id="fatherstatus" name="fatherstatus" class="form-control" value="' . $row['fatherstatus'] . '">
      </div>

      <div class="form-group">
        <label> Father Name </label>
        <input disabled type="text" id="fathername" name="fathername" class="form-control" value="' . $row['fathername'] . '">
      </div>

      <div class="form-group">
        <label> Father Occupation </label>
        <input disabled type="text" id="fatheroccupation" name="fatheroccupation" class="form-control" value="' . $row['fatheroccupation'] . '">
      </div>

      <div class="form-group">
        <label> Father Education </label>
        <input disabled type="text" id="fathereducation" name="fathereducation" class="form-control" value="' . $row['fathereducation'] . '">
      </div>

      <div class="form-group">
        <label> Mother Status </label>
        <input disabled type="text" id="motherstatus" name="motherstatus" class="form-control" value="' . $row['motherstatus'] . '">
      </div>

      <div class="form-group">
        <label> Mother Name </label>
        <input disabled type="text" id="mothername" name="mothername" class="form-control" value="' . $row['mothername'] . '">
      </div>

      <div class="form-group">
        <label> Mother Occupation </label>
        <input disabled type="text" id="motheroccupation" name="motheroccupation" class="form-control" value="' . $row['motheroccupation'] . '">
      </div>

      <div class="form-group">
        <label> Mother Education </label>
        <input disabled type="text" id="mothereducation" name="mothereducation" class="form-control" value="' . $row['mothereducation'] . '">
      </div>

      <div class="form-group">
        <label> Total Gross Income </label>
        <input disabled type="text" id="totalgrossincome" name="totalgrossincome" class="form-control" value="' . $row['totalgrossincome'] . '">
      </div>

      <div class="form-group">
        <label> Siblings </label>
        <input disabled type="text" id="siblings" name="siblings" class="form-control" value="' . $row['siblings'] . '">
      </div>

      <div class="form-group">
        <label> Status </label>
        <input disabled type="text" id="status" name="status" class="form-control" value="' . $row['status'] . '">
      </div>';
    
    
    
  }
}
