<?php

// retrieve search type
$search_type = clean_input($dbconnect, $_POST['search_type']);
$search_term = clean_input($dbconnect, $_POST['quick_search']);

// set up searches...
$quote_search = "q.Quote LIKE '%$search_term%'";

$subject_search = "
s1.Subject LIKE '%$search_term%'
OR s2.Subject LIKE '%$search_term%'
OR s3.Subject LIKE '%$search_term%'";

$name_search = "
CONCAT(a.First, ' ', a.Middle, ' ', a.Last) LIKE '%$search_term%'
OR CONCAT(a.First, ' ', a.Last) LIKE '%$search_term%'
";

if ($search_type == "quote") {
    $sql_conditions = "WHERE $quote_search";
}

elseif ($search_type == "author") {
    $sql_conditions = "";
}

elseif ($search_type == "subject") {
    $sql_conditions = "WHERE $subject_search";
}

else {
    $sql_conditions = "
    WHERE $name_search OR $quote_search OR $subject_search";
}

$heading = "'$search_term' Quotes";

include ("results.php");

?>