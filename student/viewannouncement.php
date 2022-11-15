<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "dbscholarship";
$con = new mysqli($hostname, $username, $password, $dbname);
if(isset($_POST["id"])){
    $Sql = "SELECT * FROM announcements WHERE id = '" . $_POST["id"] . "'";
    $result = mysqli_query($con, $Sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col">
        <div class="card text-left">
            <div class="card-body">
                <h5 class="card-title">' . $row['subject'] . '(' . $row['date'] . ')</h5><br>
                <p class="card-text" style="white-space: pre-wrap;">' . $row['announcement'] . '</p>
            </div>
        </div>
    </div>';
    }
}
?>