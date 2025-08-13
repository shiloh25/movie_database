<?php

// retrieve search type
$search_type = clean_input($dbconnect, $_REQUEST['search']);

if ($search_type == "all") {
    $heading = "All Movies";
    $sql_conditions = "";
}

elseif ($search_type == "recent") {
    $heading = "Recent Movies";
    $sql_conditions = "ORDER BY m.Movie_ID DESC LIMIT 10";
}

elseif ($search_type == "random") {
    $heading = "Random Movies";
    $sql_conditions = "ORDER BY RAND() LIMIT 10";
}

elseif ($search_type=="director") {
    // retrieve director ID
    $director_ID = $_REQUEST['Director_ID'];
    
    $heading = "";
    $heading_type = "director";

    $sql_conditions = "WHERE m.Director_ID = $director_ID";
}

else {
    $heading = "No results test";
    $sql_conditions = "WHERE m.Movie_ID = 1000";
}

include("results.php");

?>