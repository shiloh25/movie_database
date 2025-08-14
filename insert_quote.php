<?php

// check user is logged on
if (isset($_SESSION['admin'])) {

    if (isset($_REQUEST['submit'])) {

        // retrieve data from form
        $movie = $_REQUEST['movie'];

        $director_full = $_REQUEST['director_full'];

        $first = "";
        $last = "";

        // handle blank fields
        if ($director_full == "") {
            $director_full = $first = "Anonymous";
        }

        // check to see if director is in DB, if it isn't add it
        // check to see if director exists
        $find_director_id = "SELECT * FROM director d WHERE CONCAT(d.First, ' ', 
        d.Last) LIKE '%$director_full%'"; 
        $find_director_query = mysqli_query($dbconnect, $find_director_id);
        $find_director_rs = mysqli_fetch_assoc($find_director_query);
        $director_count = mysqli_num_rows($find_director_query);

        // retrieve director ID if director exists
        if ($director_count > 0) {
            $director_ID = $find_director_rs['Director_ID'];
        }

        else {
            // split director name and add to DB
            $names = explode(' ', $director_full);

            if (count($names) > 1) {
                $first = $names[0];
                $last = $names[count($names) - 1];
            }
            elseif (count($names) == 1) {
                $first = $names[0];
            }

            // add name to DB
            $stmt = $dbconnect -> prepare("INSERT INTO `director` (
            `First`, `Last`) VALUES (?, ?); ");
            $stmt -> bind_param("ss", $first, $last);
            $stmt -> execute();

            $director_ID = $dbconnect -> insert_id;

        } // end name split else

        // insert quote
        $stmt = $dbconnect -> prepare("INSERT INTO `movies` (`Director_ID`,
        `Title`) VALUES (?, ?); ");
        $stmt -> bind_param("is", $director_ID, $movie);
        $stmt -> execute();

        $Movie_ID = $dbconnect -> insert_id;
        
        // close stmt once everything has been inserted
        $stmt -> close();

        $heading = "Movie Success";
        $sql_conditions = "WHERE Movie_ID = $Movie_ID";

        include("content/results.php");

    } // end submit button pushed

} // end user logged on if

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}


?>