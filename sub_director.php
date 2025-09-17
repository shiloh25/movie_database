<?php
// get director full name from database
$director_full_sql = "
    SELECT DISTINCT CONCAT(First, ' ', Last) AS Full_Name
    FROM director
    ORDER BY Full_Name
";
$all_directors = autocomplete_list($dbconnect, $director_full_sql, 'Full_Name');

?>