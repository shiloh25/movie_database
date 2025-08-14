<?php

// retrieve search type
$search_type = clean_input($dbconnect, $_POST['search_type']);
$search_term = clean_input($dbconnect, $_POST['quick_search']);

// set up searches...
$movie_search = "m.Title LIKE '%$search_term%'";

$name_search = "
CONCAT(d.First, ' ', d.Last) LIKE '%$search_term%'";

if ($search_type == "movie") {
    $sql_conditions = "WHERE $movie_search";
}

elseif ($search_type == "director") {
    $sql_conditions = "";
}

else {
    $sql_conditions = "
    WHERE $name_search OR $movie_search";
}

$heading = "'$search_term' Movies";

include ("results.php");

?>