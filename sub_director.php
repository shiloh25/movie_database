<?php
// get director full name from database
$director_full_sql = "SELECT *, CONCAT(First, '  ', Last) AS 
Full_Name FROM director" ;
$all_directors = autocomplete_list($dbconnect, $director_full_sql, 'Full_Name');

?>