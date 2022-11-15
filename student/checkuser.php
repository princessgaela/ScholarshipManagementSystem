<?php

session_start();

if (isset($_POST['type']) && $_POST['type'] == 'logout') {
	
    if ((time() - $_SESSION['LAST_ACTIVE_TIME']) > 86400) {  // 60*10 Time in Seconds		
		
	echo "logout";
    }

}else{
		
    if (isset($_SESSION['LAST_ACTIVE_TIME'])) {
    	if ((time() - $_SESSION['LAST_ACTIVE_TIME']) > 86400) {  // 60*10 Time in Seconds
	    header("Location:../logout.php");
	    die();
	}
    }

    $_SESSION['LAST_ACTIVE_TIME'] = time();

    if (!isset($_SESSION['NAME'])) {
	header("Location:../userlogin.php");
	die();
    }
}

?>