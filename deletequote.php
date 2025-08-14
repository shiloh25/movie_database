<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

    $Movie_ID = $_REQUEST['Movie_ID'];
    $director_ID = $_REQUEST['director'];

    delete_ghost($dbconnect, $director_ID);

    $delete_sql = "DELETE FROM `movies` WHERE `movies`.`Movie_ID` = $Movie_ID";
    $delete_query = mysqli_query($dbconnect, $delete_sql);

    ?>
    <h2>Delete Success</h2>

    <p>The requested movie has been deleted.</p>

    <?php

} // end user logged on if

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>