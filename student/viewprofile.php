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
                        <div class=" form-group">
                            <label> Student No. </label>
                            <input readonly type="text" id="studentno" name="studentno" class="form-control" value="' . $row['studentno'] . '">
                        </div>
                        <div class="form-group">
                            <label> Name </label>
                            <input type="text" id="name" name="name" class="form-control" value="' . $row['name'] . '">
                        </div>
                        <div class="form-group">
                            <label> College Department</label>
                            <select required id="course" name="course" class="form-control" value="' . $row['course'] . '">
                                <option></option>
                                <option value="CAS" '.(($row['course']=='CAS')?'selected="selected"':"").'>CAS</option>
                                <option value="CEA" '.(($row['course']=='CEA')?'selected="selected"':"").'>CEA</option>
                                <option value="CITE" '.(($row['course']=='CITE')?'selected="selected"':"").'>CITE</option>
                                <option value="CELA" '.(($row['course']=='CELA')?'selected="selected"':"").'>CELA</option>
                                <option value="CHS" '.(($row['course']=='CHS')?'selected="selected"':"").'>CHS</option>
                                <option value="CMA" '.(($row['course']=='CMA')?'selected="selected"':"").'>CMA</option>
                                
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label> Year Level </label>
                            <select required id="yearlevel" name="yearlevel" class="form-control" value="' . $row['yearlevel'] . '">
                                <option></option>
                                <option value="1ST YEAR"'.(($row['yearlevel']=='1ST YEAR')?'selected="selected"':"").'>1st Year</option>
                                <option value="2ND YEAR"'.(($row['yearlevel']=='2ND YEAR')?'selected="selected"':"").'>2nd Year</option>
                                <option value="3RD YEAR"'.(($row['yearlevel']=='3RD YEAR')?'selected="selected"':"").'>3th Year</option>
                                <option value="4TH YEAR"'.(($row['yearlevel']=='4TH YEAR')?'selected="selected"':"").'>4th Year</option>
                                <option value="5TH YEAR"'.(($row['yearlevel']=='5TH YEAR')?'selected="selected"':"").'>5th Year</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Date Of Birth </label>
                            <input required type="date" id="dateofbirth" name="dateofbirth" class="form-control" value="' . $row['dateofbirth'] . '">
                        </div>
                        <div class="form-group">
                            <label> Gender </label>
                            <select required id="gender" name="gender" class="form-control" value="' . $row['gender'] . '">
                                <option></option>
                                <option value="MALE" '.(($row['gender']=='MALE')?'selected="selected"':"").'>Male</option>
                                <option value="FEMALE" '.(($row['gender']=='FEMALE')?'selected="selected"':"").'>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Address </label>
                            <input required type="text" id="address" name="address" class="form-control" value="' . $row['address'] . '">
                        </div>
                        <div class="form-group">
                            <label> Civil Status </label>
                            <select required id="civilstatus" name="civilstatus" class="form-control" value="' . $row['civilstatus'] . '">
                                <option></option>
                                <option value="SINGLE" '.(($row['civilstatus']=='SINGLE')?'selected="selected"':"").'>Single</option>
                                <option value="MARRIED" '.(($row['civilstatus']=='MARRIED')?'selected="selected"':"").'>Married</option>
                                <option value="DIVORCED" '.(($row['civilstatus']=='DIVORCED')?'selected="selected"':"").'>Divorced</option>
                                <option value="WIDOWED" '.(($row['civilstatus']=='WIDOWED')?'selected="selected"':"").'>Widowed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Citizenship </label>
                            <input required type="text" id="citizenship" name="citizenship" class="form-control" value="' . $row['citizenship'] . '">
                        </div>
                        <div class="form-group">
                            <label> Contact No. </label>
                            <input required type="text" id="contactno" name="contactno" class="form-control" value="' . $row['contactno'] . '"
                        </div>
                        <div class="form-group">
                            <label> Zip Code </label>
                            <input required type="text" id="zipcode" name="zipcode" class="form-control" value="' . $row['zipcode'] . '">
                        </div>
                        <div class="form-group">
                            <label> Email </label>
                            <input required type="email" id="email" name="emailaddress" class="form-control" value="' . $row['emailaddress'] . '">
                        </div>
                        <div class="form-group">
                            <label> Father Status </label>
                            <select required id="fatherstatus" name="fatherstatus" class="form-control" value="' . $row['fatherstatus'] . '">
                                <option></option>
                                <option value="DECEASED" '.(($row['fatherstatus']=='DECEASED')?'selected="selected"':"").'>Deceased</option>
                                <option value="LIVING" '.(($row['fatherstatus']=='LIVING')?'selected="selected"':"").'>Living</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Father Name </label>
                            <input required type="text" id="fathername" name="fathername" class="form-control" value="' . $row['fathername'] . '">
                        </div>
                        <div class="form-group">
                            <label> Father Occupation </label>
                            <input required type="text" id="fatheroccupation" name="fatheroccupation" class="form-control" value="' . $row['fatheroccupation'] . '">
                        </div>
                        <div class="form-group">
                            <label> Father Education </label>
                            <select required id="fathereducation" name="fathereducation" class="form-control" value="' . $row['fathereducation'] . '">
                                <option></option>
                                <option value="ELEMENTARY" '.(($row['fathereducation']=='ELEMENTARY')?'selected="selected"':"").'>Elementary</option>
                                <option value="HIGH SCHOOL" '.(($row['fathereducation']=='HIGH SCHOOL')?'selected="selected"':"").'>High School</option>
                                <option value="TECHNICAL VOCATIONAL" '.(($row['fathereducation']=='TECHNICAL VOCATIONAL')?'selected="selected"':"").'>Technical Vocational</option>
                                <option value="BACHELORS DEGREE IN COLLEGE" '.(($row['fathereducation']=='BACHELORS DEGREE IN COLLEGE')?'selected="selected"':"").'>Bachelors Degree in College</option>
                                <option value="MASTERATE IN GRADUATE SCHOOL" '.(($row['fathereducation']=='MASTERATE IN GRADUATE SCHOOL')?'selected="selected"':"").'>Masterate in Graduate School</option>
                                <option value="DOCTORATE IN POST GRADUATE STUDIES" '.(($row['fathereducation']=='DOCTORATE IN POST GRADUATE STUDIES')?'selected="selected"':"").'>Doctorate in Post Graduate Studies</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Mother Status </label>
                            <select required id="motherstatus" name="motherstatus" class="form-control" value="' . $row['motherstatus'] . '">
                                <option></option>
                                <option value="DECEASED" '.(($row['motherstatus']=='DECEASED')?'selected="selected"':"").'>Deceased</option>
                                <option value="LIVING" '.(($row['motherstatus']=='LIVING')?'selected="selected"':"").'>Living</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Mother Name </label>
                            <input required type="text" id="mothername" name="mothername" class="form-control" value="' . $row['mothername'] . '">
                        </div>
                        <div class="form-group">
                            <label> Mother Occupation </label>
                            <input required type="text" id="motheroccupation" name="motheroccupation" class="form-control" value="' . $row['motheroccupation'] . '">
                        </div>
                        <div class="form-group">
                            <label> Mother Education </label>
                            <select required id="mothereducation" name="mothereducation" class="form-control" value="' . $row['mothereducation'] . '">
                                <option></option>
                                <option value="ELEMENTARY" '.(($row['mothereducation']=='ELEMENTARY')?'selected="selected"':"").'>Elementary</option>
                                <option value="HIGH SCHOOL" '.(($row['mothereducation']=='HIGH SCHOOL')?'selected="selected"':"").'>High School</option>
                                <option value="TECHNICAL VOCATIONAL" '.(($row['mothereducation']=='TECHNICAL VOCATIONAL')?'selected="selected"':"").'>Technical Vocational</option>
                                <option value="BACHELORS DEGREE IN COLLEGE" '.(($row['mothereducation']=='BACHELORS DEGREE IN COLLEGE')?'selected="selected"':"").'>Bachelors Degree in College</option>
                                <option value="MASTERATE IN GRADUATE SCHOOL" '.(($row['mothereducation']=='MASTERATE IN GRADUATE SCHOOL')?'selected="selected"':"").'>Masterate in Graduate School</option>
                                <option value="DOCTORATE IN POST GRADUATE STUDIES" '.(($row['mothereducation']=='DOCTORATE IN POST GRADUATE STUDIES')?'selected="selected"':"").'>Doctorate in Post Graduate Studies</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Total Gross Income </label>
                            <input required type="number" id="totalgrossincome" name="totalgrossincome" class="form-control" value="' . $row['totalgrossincome'] . '">
                        </div>
                        <div class="form-group">
                            <label> Siblings </label>
                            <input required type="number" id="siblings" name="siblings" class="form-control" value="' . $row['siblings'] . '">
                        </div>';
    }
}
?>