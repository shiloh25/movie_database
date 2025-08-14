<?php

// check user is logged on
if(isset($_SESSION['admin'])) {

    // retrieve quote ID and sanitise it in case someone edits the URL
    $Movie_ID = filter_var($_REQUEST['Movie_ID'], FILTER_SANITIZE_NUMBER_INT);

    // adjust heading and find quote
    $heading_type = "delete_movie";
    $heading = "";
    $sql_conditions = "WHERE Movie_ID = $Movie_ID";

    include("content/results.php");

    // check that variable is defined and set to 0 if not
    if ($find_rs && isset($find_rs['Director_ID'])) {
        $director_ID = $find_rs['Director_ID'];
    } 
    else {
        $director_ID = 0; 
    }

    ?>

    <p>
        <span class="tag white-tag">
        <a href="index.php?page=../admin/deletequote&Movie_ID=<?php echo $Movie_ID; 
        ?>&director=<?php echo $director_ID ?>">Yes, Delete it!</a>
        </span>

        &nbsp;

        <span class="tag white-tag">
        <a href="index.php">No, take me back</a>
        </span>
    </p>

    <?php

} // end user logged on if

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>