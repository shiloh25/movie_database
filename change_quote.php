<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

    if (isset($_REQUEST['submit'])) {

        // retrieve movie and director ID from form
        // check they are integers (in case someone edits the URL)
        $movie_ID = filter_var($_REQUEST['Movie_ID'], FILTER_SANITIZE_NUMBER_INT);
        $old_director = filter_var($_REQUEST['directorID'],
        FILTER_SANITIZE_NUMBER_INT);
        
        include("process_form.php");

        // delete director if there are no movies associated with that director
        if ($old_author != $author_ID) {
            delete_ghost($dbconnect, $old_author);
        } // end check author changed

        // update quote
        $stmt = $dbconnect -> prepare("UPDATE `quotes` SET `Author_ID` = ?,
        `Quote` = ?, `Subject1_ID` = ?, `Subject2_ID` = ?, `Subject3_ID` = ?
        WHERE `ID` = ?;");
        $stmt -> bind_param("isiiii", $author_ID, $quote, $subject_ID_1, 
        $subject_ID_2, $subject_ID_3, $quote_ID);
        $stmt -> execute();

        // close stmt once everything has been inserted
        $stmt -> close();
        
        $heading = "";
        $heading_type = "edit_success";
        $sql_conditions = "WHERE ID = $quote_ID";

        include("content/results.php");

    } // end submit button pushed

} // end user logged on if

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}


?>