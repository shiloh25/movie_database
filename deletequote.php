<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

    $ID = $_REQUEST['ID'];
    $author_ID = $_REQUEST['author'];

    delete_ghost($dbconnect, $author_ID);

    $delete_sql = "DELETE FROM `quotes` WHERE `quotes`. `ID` = $ID";
    $delete_query = mysqli_query($dbconnect, $delete_sql);

    ?>
    <h2>Delete Success</h2>

    <p>The requested quote has been deleted.</p>

    <?php

} // end user logged on if

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>