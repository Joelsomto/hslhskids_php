<?php

function redirect_to($new_location){
    header("Location: ". $new_location);
    exit;
}
function confirm_login()
{
    if (isset($_SESSION['id'])) {
        return true;
    } else {
        $_SESSION['errorMsg'] = "Login required!";
        redirect_to("login.php");
    }
}

?>
