<?php

// retrieve data from form
    $movie = $_REQUEST['movie'];

    $director_full = $_REQUEST['director_full'];

    $first = "";
    $last = "";

    // initialise ID
    $director_ID = "";

    // handle blank fields
    if ($director_full == "") {
    $director_full = $first = "Anonymous";
    }

    // check to see if director is in DB, if it isn't add it
    // check to see if author exists
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
    $stmt -> bind_param("sss", $first, $last);
    $stmt -> execute();

    $director_ID = $dbconnect -> insert_id;

    } // end name split else

?>